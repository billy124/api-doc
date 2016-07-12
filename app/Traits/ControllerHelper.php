<?php

namespace App\Traits;

use Illuminate\Http\Request;
use App\Http\ResponseFormatters\JSONFormatter;
use App\Http\ResponseFormatters\JSONErrorFormatter;
use Illuminate\Http\Response as BaseResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Validator;

trait ControllerHelper {
    
    protected $load = [];
    protected $except = [];
    protected $id_col = 'id';
    protected $authOverride = false;
    
    public function setIdCol($id_col) {
        $this->id_col = $id_col;
    }
    
    public function getIdCol() {
        return $this->id_col;
    }
    
    protected function auth() {
        if (isset($_GET['auth'])) {
            $this->except = [];
            $this->authOverride = true;
        }

        $this->middleware('jwt.auth', ['except' => $this->except]);
    }
    

    public function index(Request $request, $id = null) {
        return $this->showAllByFields();
    }
    
    public function show($id) {
        return $this->showBy($this->id_col, $id);
    }

    protected function storeEntity($data) {
        $model = $this->saveEntity($data, $this->model);
        if (!isset($model->id)) {
            return $model;
        }
        return JSONFormatter::output($model);
    }

    public function store(Request $request, $id = null) {
        return $this->storeEntity($request->all());
    }

    public function storeByRelation(Request $request, $id, $field) {
        $data = array_merge([$field => $id], $request->all());
        return $this->storeEntity($data);
    }

    protected function saveEntity($data, $model) {
        $validator = Validator::make($data, $model->rules(), $model->messages());
        if ($validator->fails()) {
            return JSONErrorFormatter::output($validator->errors()->getMessages());
        } else {
            $model->fill($data);
            try {
                $model->save();
            } catch (\Exception $e) {
                return JSONErrorFormatter::output(['error' => $e->getMessage()], BaseResponse::HTTP_INTERNAL_SERVER_ERROR);
            }
            return $model;
        }
    }
    
    public function saveEntities($records, $model) {
        foreach($records as $data) {
            $model = new $model;
            $model->fill($data);
            try {
                $model->save();
            } catch (\Exception $e) {
                return JSONErrorFormatter::output(['error' => $e->getMessage()], BaseResponse::HTTP_INTERNAL_SERVER_ERROR);
            }
            
        }
        
    }

    public function update(Request $request, $id) {
        
        $entity = $this->getByFields([$this->getIdCol() => $id]);
        $entity->fill($request->all());
        
        $validator = Validator::make($entity->toArray(), $this->model->rules($id), $this->model->messages());

        if ($validator->fails()) {
            
            return JSONErrorFormatter::output($validator->errors()->getMessages());
        } else {
            try {
                $entity->update();
            } catch (\Exception $e) {
                return JSONErrorFormatter::output(['error' => $e->getMessage()], BaseResponse::HTTP_INTERNAL_SERVER_ERROR);
            }
            return JSONFormatter::output($entity);
        }
    }

    public function destroy($id) {
        $entity = $this->getByFields([$this->id_col => $id])->delete();
        return response(null, BaseResponse::HTTP_NO_CONTENT);
    }

    protected function getByFields($array, $load = true) {
        $items = $this->getAllByFields($array, $load);

        if (count($items) == 0) {
            throw new NotFoundHttpException();
        }

        return $items[0];
    }

    protected function getAllByFields($array, $load = true) {
        $query = $this->model;
        foreach ($array as $key => $value) {
            $query = $this->model->where($key, $value);
        }

        $items = $query->get();
        if ($load) {
            for ($i = 0; $i < count($items); $i++) {
                $items[$i]->load($this->load);
            }
        }
        return $items;
    }

    protected function showBy($key, $value) {
        return $this->showByFields([$key => $value]);
    }

    protected function showByFields($array) {
        $item = $this->getByFields($array);
        $item->load($this->load);
        return JSONFormatter::output($item->toArray());
    }

    protected function showAllByFields($array = []) {
        $items = $this->getAllByFields($array);
        
        for ($i = 0; $i < count($items); $i++) {
            $items[$i]->load($this->load);
        }

        return JSONFormatter::output([
                    'items' => $items
        ]);
    }
}