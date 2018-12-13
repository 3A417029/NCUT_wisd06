<?php

namespace App\Admin\Controllers;

use App\Models\Product;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class ProductsController extends Controller
{
    //
    use ModelForm;
    /**
    * Index interface.
    *
    * @return Content
    */
    public function index()
    {
        return Admin::content(function (Content $content) {
            $content->header('商品列表');
            $content->body($this->grid());
        });
    }
    /**
    * Edit interface.
    *
    * @param $id
    * @return Content
    */
    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {
            $content->header('編輯商品');
            $content->body($this->form()->edit($id));
        });
    }
     /**
     * Create interface.
     *
     * @return Content
     */
    public function create()
    {
        return Admin::content(function (Content $content) {
            $content->header('新增商品');
            $content->body($this->form());
        });
    }
     /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(Product::class, function (Grid $grid) {
            $grid->id('ID')->sortable();
            $grid->title('商品名稱');
            $grid->on_sale('上架')->display(function ($value) {
                return $value ? '是' : '否';
            });
            $grid->price('價格');
            $grid->rating('評價');
            $grid->sold_count('銷量');
            $grid->review_count('評論');
            $grid->actions(function ($actions) {
                $actions->disableDelete();
            });
        });
    }
    /**
    * Make a form builder.
    *
    * @return Form
    */
    protected function form()
    {
        return Admin::form(Product::class, function (Form $form) {
                $form->text('title', '商品名稱')->rules('required');
                $form->image('image', '商品圖片')->rules('required|image');
                $form->editor('description', '商品內容')->rules('required');
                $form->radio('on_sale', '上架')->options(['1' => '是', '0'=> '否'])->default('0');
                $form->hasMany('skus', function (Form\NestedForm $form) {
                $form->text('title', '庫存')->rules('required');
                $form->text('description', '庫存描述')->rules('required');
                $form->text('price', '價格')->rules('required|numeric|min:0.01');
                $form->text('stock', '剩餘數量')->rules('required|integer|min:0');
            });
            $form->saving(function (Form $form) {
                $form->model()->price = collect($form->skus)->min('price');
            }); 
        });
    }
}
