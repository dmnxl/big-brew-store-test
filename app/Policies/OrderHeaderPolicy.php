<?php

namespace App\Policies;

use App\Models\UserAcc;
use App\Models\order_header;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderHeaderPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\UserAcc  $userAcc
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(UserAcc $userAcc)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\UserAcc  $userAcc
     * @param  \App\Models\order_header  $orderHeader
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(UserAcc $userAcc, order_header $orderHeader)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\UserAcc  $userAcc
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(UserAcc $userAcc)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\UserAcc  $userAcc
     * @param  \App\Models\order_header  $orderHeader
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(UserAcc $userAcc, order_header $orderHeader)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\UserAcc  $userAcc
     * @param  \App\Models\order_header  $orderHeader
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(UserAcc $userAcc, order_header $orderHeader)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\UserAcc  $userAcc
     * @param  \App\Models\order_header  $orderHeader
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(UserAcc $userAcc, order_header $orderHeader)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\UserAcc  $userAcc
     * @param  \App\Models\order_header  $orderHeader
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(UserAcc $userAcc, order_header $orderHeader)
    {
        //
    }
}
