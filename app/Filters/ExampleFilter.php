<?php


namespace App\Filters;


use Carbon\Carbon;
use Leandreaci\Filterable\QueryFilter;

class TransactionFilter extends QueryFilter
{

    public function id($id)
    {
        return $this->builder->where('id', $id);
    }

    public function start($date)
    {
        try{
            $formattedDate = Carbon::createFromFormat('Y-m-d', $date)->startOfDay()->toDateTimeString();
            return $this->builder->where('created_at','>', $formattedDate);
        }catch (\Exception $exception)
        {
            return $this->builder;
        }
    }

    public function end($date)
    {
        try{
            $formattedDate = Carbon::createFromFormat('Y-m-d', $date)->endOfDay()->toDateTimeString();
            return $this->builder->where('created_at','<', $formattedDate);
        }catch (\Exception $exception)
        {
            return $this->builder;
        }

    }


}
