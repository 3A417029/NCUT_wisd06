<?php

namespace App\Admin\Controllers;
use App\Models\User;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class UsersController extends Controller
{
    use ModelForm;
    public function index()
    {
        return Admin::content(function (Content $content) {
            $content->header('使用者列表');
            $content->body($this->grid());
        });
    }
    protected function grid()
    {
        return Admin::grid(User::class, function (Grid $grid) {
            $grid->id('ID')->sortable();
            $grid->name('使用者名稱');
            $grid->email('E-Mail');
            $grid->email_verified('已驗證信箱')->display(function ($value) {
                return $value ? '是' : '否';
            });
            $grid->created_at('註冊時間');
            $grid->disableCreateButton();
            $grid->actions(function ($actions) {
                $actions->disableDelete();
                $actions->disableEdit();
            });
            $grid->tools(function ($tools) {
                $tools->batch(function ($batch) {
                    $batch->disableDelete();
                });
            });
        });
    }
}