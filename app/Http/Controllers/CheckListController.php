<?php

namespace App\Http\Controllers;

use App\Http\Helpers\Response;
use App\Http\Services\CheckListService;
use Illuminate\Http\Request;

class CheckListController extends Controller
{
    public $checkListService;
    public function __construct(CheckListService $checkListService) {
        $this->checkListService = $checkListService;
    }

    public function getByTaskId($task_id)
    {
        return Response::response($this->checkListService->getByColumn("task_id",$task_id)->sortBy("order_no"));
    }

    public function update(Request $request,$id)
    {
        return Response::response($this->checkListService->updateById($id,$request->all()));
    }
}
