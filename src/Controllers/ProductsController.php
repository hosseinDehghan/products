<?php

namespace Hosein\Products\Controllers;

use Hosein\Products\Controllers;

use App\Http\Controllers\Controller;
use Hosein\Products\CategoryProduct;
use Hosein\Products\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductsController extends Controller
{
    public function index($id=null){

        if($id==null||!is_numeric($id)){
            $data["id"]=0;
        }
        else{
            $data["id"]=$id;
        }
        $data["listCategory"]=$this->listCategory();
        $data["listProduct"]=$this->listProducts();
        return view("ProductView::products",$data);
    }
    public function createCategory(Request $request,$id){
        $validator=Validator::make($request->all(),[
            "name"=>'required|max:255|string'
        ]);
        if($validator->fails()){
            return redirect('products/'.$id)
                ->withErrors($validator,"category")
                ->withInput();
        }
        $this->setParentChild($id);
        $category=new CategoryProduct();
        $category->name=$request->all()["name"];
        $category->parent=$id;
        $category->is_parent=0;
        $category->save();
        return redirect('products');
    }
    public function editCategory($cat,$id){
        $category=CategoryProduct::where("id",$id)->first();
        return redirect("products/$id")->with("category_name",$category->name);
    }
    public function categoryUpdate(Request $request,$id){
        $category=CategoryProduct::where("id",$id)->first();
        $category->name=$request->all()["name"];
        $category->save();
        return redirect("products");
    }
    public function listCategory(){
        $category=CategoryProduct::select("*")->get();
        return $category;
    }
    public function setParentChild($id){
        $category=CategoryProduct::where("id",$id)->first();
        if(!empty($category)) {
            $category->is_parent = 1;
            $category->save();
        }
    }
    public function deletecategory($id){
        $category=CategoryProduct::where("id",$id)->first();
        $category->delete();
        return redirect("products");
    }

    public function createProduct(Request $request){
        $input=$request->all();
        $validator=Validator::make($input,[
            "title"=>'required|max:255|string',
            "summery"=>'required|max:512|string',
            "details"=>'required|string',
            "image"=>'required|mimes:jpg,jpeg,png|max:10000',
            "some"=>'required|integer',
            "price"=>'required|integer',
            "off"=>'required|integer'
        ]);
        if($validator->fails()){
            return redirect('products')
                ->withErrors($validator,"products")
                ->withInput();
        }
        $file = $request->file('image');
        $destination=public_path()."/upload/";
        $filename=$this->uploadfile($destination,$file);
        if($filename!=false){
            $product=new Products();
            $product->title=$request->all()["title"];
            $product->summery=$request->all()["summery"];
            $product->details=$request->all()["details"];
            $product->image=$filename;
            $product->category_id=$request->all()["category"];
            $product->some=$request->all()["some"];
            $product->price=$request->all()["price"];
            $product->off=$request->all()["off"];
            $product->like=0;
            $product->disLike=0;
            $product->visited=0;
            $product->save();
        }
        return redirect('products');
    }
    public function listProducts(){
        $product=Products::select("*")->get();
        return $product;
    }
    public function editProduct($id){
        $blog=Products::where("id",$id)->first();
        return redirect("products")->with("product",$blog);
    }
    public function productUpdate(Request $request,$id){
        $product=Products::where("id",$id)->first();
        $destination=public_path()."/upload/";
        $file=$product->image;
        if(!empty($request->file("image"))){
            $oldfile=$file;
            $file=$this->uploadfile($destination,$request->file("image"));
            if($file!=false){
                $this->deletefile($destination,$oldfile);
            }
        }
        $product->title=$request->all()["title"];
        $product->summery=$request->all()["summery"];
        $product->details=$request->all()["details"];
        $product->image=$file;
        $product->category_id=$request->all()["category"];
        $product->some=$request->all()["some"];
        $product->price=$request->all()["price"];
        $product->off=$request->all()["off"];
        $product->save();
        return redirect("products");
    }
    public function deleteProduct($id){
        $product=Products::where("id",$id)->first();
        $destination=public_path()."/upload/";
        if(file_exists(public_path()."/upload/".$product->image))
            $this->deletefile($destination,$product->image);
        $product->delete();
        return redirect("products");
    }
    public function uploadfile($destination,$file){
        $filename=$file->getClientOriginalName();
        $name=explode('.',$file->getClientOriginalName())[0];
        $extenstion=$file->getClientOriginalExtension();
        while(file_exists($destination.$filename)){
            $filename=$name."_".rand(1,10000000).".".$extenstion;
        }
        if($file->move($destination,$filename)){
            return $filename;
        }
        return false;
    }
    public function deletefile($destination,$filename){
        if(file_exists($destination."/".$filename)){
            unlink($destination."/".$filename);
            return 1;
        }
        return 0;
    }
}
