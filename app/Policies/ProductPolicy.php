<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\UserAcc;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductPolicy
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
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(UserAcc $userAcc, Product $product)
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
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(UserAcc $userAcc, Product $product)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\UserAcc  $userAcc
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(UserAcc $userAcc, Product $product)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\UserAcc  $userAcc
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(UserAcc $userAcc, Product $product)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\UserAcc  $userAcc
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(UserAcc $userAcc, Product $product)
    {
        //
    }
}
