<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Customer;
use App\Models\Material;
use App\Models\Projects;
use App\Models\Position;
use App\Models\Config;
use App\Models\ProjectMaterials;
use App\Models\ProjectStep;
use App\Models\ProjectWorker;

class ProjectController extends Controller
{
    /**
     * Create a Projects
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        // validations
        $validatedData = $request->validate([
            'customer.name' => 'required|string|max:255',
            'customer.email' => 'required|email',
            'customer.phone' => 'required|string|max:20',
            'customer.address' => 'required|string|max:255',
            'customer.city_id' => 'required|integer',
            'product_id' => 'required|integer|exists:products,id',
            'transport_cost'=>'numeric',
            'custom_profit'=>'numeric',
            'materials' => 'required|array',
            'materials.*.material_id' => 'required|integer',
            'materials.*.qty' => 'required|integer',
            'materials.*.customPrice' => 'required|numeric',
            'project_steps' => 'required|array',
            'project_steps.*.name' => 'required|string|max:255',
            'project_steps.*.notes' => 'nullable|string',
            'project_steps.*.rank' => 'required|integer',
            'project_steps.*.duration' => 'required|integer',
            'project_steps.*.workers' => 'required|array',
            'project_steps.*.workers.*.position' => 'required',
            'project_steps.*.workers.*.salary' => 'required|numeric',
        ]);
        //transaction begin
        DB::beginTransaction();
        try{
            // Check if customer already exists
            $customerData = $validatedData['customer'];
            $customer = Customer::where('email', $customerData['email'])
                ->orWhere('phone', $customerData['phone'])
                ->first();

            if (!$customer) {
                // Create new customer
                $customer = Customer::create($customerData);
            }

            $project = new Projects();
            $project->customer_id = $customer->id;
            $project->product_id = $validatedData['product_id'];
            $project->projectNo  = $this->generateProjectNo();
            $project->transport_cost = $validatedData['transport_cost'];
            $project->type="OFFERING";
            $project->is_active = true;
            $project->amount = 0;
            $project->profit = 0;
            $project->customProfit = $validatedData['custom_profit'];
            $project->reason = "";
            $project->save();
            //hitung total biaya material
            $totalBiayaMaterial = $this->prosesMaterials($validatedData['materials'],$project->projectNo);
            [$totalBiayaSteps,$duration] = $this->prosesSteps($validatedData['project_steps'],$project->projectNo);
            $config = Config::where('key',KEY_LABA)->first();
            $totalLabaDiharapkan = $config->value * $duration;


            $project->profit = $config->value;

            $project->customProfit = $validatedData['custom_profit'];
            
            $totalBiayaProyek = $totalLabaDiharapkan + $totalBiayaMaterial + $totalBiayaSteps;
            if($validatedData['custom_profit'] != 0){
                $totalBiayaProyek = ($totalBiayaMaterial + $totalBiayaSteps) + ((($totalBiayaMaterial + $totalBiayaSteps) / 100) * $validatedData['custom_profit'] );
            }
            $project->amount = $totalBiayaProyek;
            $project->save();



            DB::commit();
            return response()->json(["message"=>"project has been created !"], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }

        return response()->json($validated);
    }

    private function generateProjectNo()
    {
        $lastProject = Projects::orderBy('projectNo', 'desc')->first();
        $lastProjectNo = $lastProject ? $lastProject->projectNo : 'POEAP000001';
        $number = (int)substr($lastProjectNo, 5);
        $newNumber = $number + 1;
        return 'POEAP' . str_pad($newNumber, 5, '0', STR_PAD_LEFT);
    }

    private function getSalaryPerday($type,$salary){
        switch ($type) {
            case 'MONTH':
                return $salary/30;
                break;
            case 'WEEK':
                return $salary/7;
                break;
            default:
            return $salary;
                break;
        }
    }
    private function prosesMaterials($materials,$projectNo){
        $totalBiayaMaterial = 0;
        foreach ($materials as $materialData) {
            $material = Material::where('id',$materialData['material_id'])->first();
            $total = 0;
            if($material){
                $total = ($materialData['customPrice'] == 0 ? $material->price : $materialData['customPrice']) * $materialData['qty'];
                $materialWillSaved = new ProjectMaterials();
                $materialWillSaved->projectNo = $projectNo;
                $materialWillSaved->materialId = $material->id;
                $materialWillSaved->qty = $materialData['qty'];
                $materialWillSaved->price = $material->price;
                $materialWillSaved->customPrice = $materialData['customPrice'];
                $materialWillSaved->deliveryStatus = "PENDING";
                $materialWillSaved->remainingQty = 0;
                $materialWillSaved->save();
            }
            $totalBiayaMaterial+=$total;
        }
        return $totalBiayaMaterial;
    }
    private function prosesSteps($steps,$projectNo){
        $totalBiayaSteps = 0;
        $duration = 0;
        foreach($steps as $step){
            $duration+=$step['duration'];
            $stepWillSaved = new ProjectStep();
            $stepWillSaved->projectNo = $projectNo;
            $stepWillSaved->name = $step['name'];
            $stepWillSaved->notes = $step['notes'];
            $stepWillSaved->rank = $step['rank'];
            $stepWillSaved->duration = $step['duration'];
            $stepWillSaved->status = "PENDING";
            $stepWillSaved->save();
            $totalBiayaWorker = $this->prosesWorker($step['workers'],$step['duration'],$stepWillSaved->id);
            $totalBiayaSteps+=$totalBiayaWorker;
        }
        return [$totalBiayaSteps,$duration];
    }
    private function prosesWorker($workers,$duration,$stepId){
        $total = 0;
        foreach($workers as $worker){
            $position = Position::with('salarys')->where('id',$worker['position']['id'])->first();
            $salary = $worker['salary'];
            $total+=($duration*$salary);
            $workerWillSaved = new ProjectWorker();
            $workerWillSaved->ProjectStepId = $stepId;
            $workerWillSaved->positionId = $position->id;
            $workerWillSaved->salary = $salary;
            $workerWillSaved->save();
        }
        return $total;
    }

    /**
     * get projects by status
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getListByStatus(Request $request){
        $validated = $request->validate([
            'type' => 'required|string|max:255',
            'offset' => 'required|numeric',
            'limit' => 'required|numeric',
        ]);// Mendapatkan proyek dengan data relasinya, menggunakan offset dan limit
        $projects = Projects::select(
                'projects.projectNo',
                'projects.amount',
                'projects.transport_cost',
                'projects.type',
                'projects.reason',
                'projects.survey_date',
                'projects.created_at',
                'projects.updated_at',
                'products.name',
                DB::raw('(SELECT COUNT(*) FROM project_materials WHERE project_materials.projectNo = projects.projectNo) AS jumlahMaterial'),
                DB::raw('(SELECT SUM(project_steps.duration) FROM project_steps WHERE project_steps.projectNo = projects.projectNo) AS duration')
            )
            ->join('products', 'projects.product_id', '=', 'products.id')
            ->where('projects.type', $validated['type'])
            ->offset($validated['offset'])
            ->limit($validated['limit'])
            ->get();
        return response()->json($projects);
    }

    public function getLabaPerhari(){
        $config = Config::where('key',KEY_LABA)->first();
        return response()->json($config);
    }

}
