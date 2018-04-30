<?php
/**
 * Created by PhpStorm.
 * User: JoséAntonio
 * Date: 12/09/2016
 * Time: 10:17
 */

namespace App\Repositories;


use Illuminate\Database\Eloquent\Model;

abstract class BaseRepo {

    abstract public function getModel();

    /*
     * Obtener Modelo con lo id indicado
     * @param int id Del modelo indicado
     * @var Model Objeto Eloquent
     */

    public function findOrFail($id)
    {
        return $this->getModel()->findOrFail($id);
    }

    /*
    * Obtener todos los Objetos de ese Model
    * @param int id Del modelo indicado
    * @var Model Objeto Eloquent
    */

    public function all()
    {
        return $this->getModel()->all();
    }
    /*
     * Crea un Modelo con lo atributos asignado de forma masiva
     * @param array data Lista de atributos que se pueden asignar de forma masiva
     * @var Model Objeto Eloquent con los campos rellenos
     */
    public function create(array $data)
    {
        return $this->getModel()->create($data);
    }

    /*
    * Actualiza un Modelo con lo atributos asignado de forma masiva
    * @param Model Objecto que se va a actualizar.
    * @param array data Lista de atributos que se pueden asignar de forma masiva
    * @var Model Objeto Eloquent con los campos rellenos
    */

    public function update(Model $entity, array $data){
        $entity->fill($data);
        $entity->save();
        return $entity;

    }
    /*
     * Actualiza un Modelo
     * @param Model Objecto que se va a actualizar.
     * @var Model Objeto Eloquent con los campos rellenos
     */
    public function updateWithoutData(Model $entity){
        $entity->save();
        return $entity;
    }

    /*
    * Elimina un Modelo
    * @param Model Objecto que se va a eliminar.
    * @var Model Objeto Eloquent con los campos rellenos
    */
    public function delete($entity){

        if(is_numeric($entity))
        {
            $entity = $this->findOrFail($entity);
        }
        $entity->delete();
        return $entity;
    }

    public function orderBy($column, $order = 'asc'){
        return $this->getModel()->orderBy($column, $order);
    }

    public function orderByEntity($entity, $column, $order = 'asc'){
        return $entity->orderBy($column, $order);
    }

    public function pluck($column, $key = null){
        return $this->getModel()->pluck($column, $key);
    }

    public function pluckEntity($entity, $column, $key = null){
        return $entity->pluck($column, $key);
    }

    public function select($array){
        return $this->getModel()->select($array);
    }

    public function selectEntity($entity, $array){
        return $entity->select($array);
    }

    public function where($column, $compare, $operator = '='){
        return $this->getModel()->where($column, $operator, $compare);
    }

    public function whereEntity($entity, $column, $compare, $operator = '='){
        return $entity->where($column, $operator, $compare);
    }

    public function firstEntity($entity){
        return $entity->first();
    }

    public function firstOrCreate($entity){

        return $entity->firstOrCreate($entity);

    }
}