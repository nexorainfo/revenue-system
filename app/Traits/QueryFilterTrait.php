<?php

namespace App\Traits;

trait QueryFilterTrait
{
    public function filterByAddress($query, $param)
    {
        if (!empty($param['address']['province_id'])) {
            if (is_array($param['address']['province_id'])) {
                $query->whereIn('province_id', $param['address']['province_id']);
            } else {
                $query->where('province_id', $param['address']['province_id']);
            }
        }
        if (!empty($param['address']['district_id'])) {
            if (is_array($param['address']['district_id'])) {
                $query->whereIn('district_id', $param['address']['district_id']);
            } else {
                $query->where('district_id', $param['address']['district_id']);
            }
        }
        if (!empty($param['address']['local_body_id'])) {
            if (is_array($param['address']['local_body_id'])) {
                $query->whereIn('local_body_id', $param['address']['local_body_id']);
            } else {
                $query->where('local_body_id', $param['address']['local_body_id']);
            }
        }
        if (!empty($param['address']['ward_no'])) {
            if (is_array($param['address']['ward_no'])) {
                $query->whereIn('ward_no', $param['address']['ward_no']);
            } else {
                $query->where('ward_no', $param['address']['ward_no']);
            }
        }

        return $query;
    }

    public function filterByUserRole($query, $param)
    {
        if (auth()->user()->role->type !== 'Super') {
            $query->where('user_id', auth()->id());
        }

        return $query;
    }
}
