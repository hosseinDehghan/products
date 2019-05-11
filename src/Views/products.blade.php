<h1>Products</h1>
<hr>
<h3>categoryProducts</h3>
<form action="@if(session("category_name")){{url("categoryPUpdate")}}/{{$id}}@else {{url("createPCategory")}}/{{$id}}@endif" method="post">
    {{csrf_field()}}
    <input type="text" name="name" value="@if(session("category_name")){{session("category_name")}}@endif" placeholder="Enter Category Name"/>
    @if(isset($errors))
        @foreach($errors->category->all() as $message)
            {{$message}}
        @endforeach
    @endif
    <input type="submit" name="send" value="send">
</form>
<hr>

<ul>

    <?php

    function lc($cat){
        $category=\Hosein\Products\CategoryProduct::select("*")->where("parent",$cat)->get();
        foreach ($category as $value){
            echo "<li><a href='".url("products/$value->parent/$value->id")."'>
                $value->name</a>------
                <a href='".url("products/$value->id")."'>create_child</a>-------
                <a href='".url("deletePCategory/$value->id")."'>delete</a>";
            if($value->is_parent==1){
                echo "<ul>";
                lc($value->id);
                echo "</ul>";
            }
            echo "</li>";
        }
    }
    lc(0);
    ?>




</ul>
<hr>
<h3>Products</h3>
<form action="@if(session("product")){{url("productUpdate")}}/{{session("product")->id}}@else {{url("createProduct")}}@endif" method="post" enctype="multipart/form-data">
    {{csrf_field()}}
    @if(isset($errors))
        @foreach($errors->products->all() as $message)
            {{$message}}
        @endforeach
    @endif

    <input type="text" name="title" value="@if(session("product")){{session("product")->title}}@endif" placeholder="Enter title"/>
    <input type="number" name="some" value="@if(session("product")){{session("product")->some}}@endif" placeholder="Enter some"/>
    <input type="number" name="price" value="@if(session("product")){{session("product")->price}}@endif" placeholder="Enter price"/>
    <input type="number" name="off" value="@if(session("product")){{session("product")->off}}@endif" placeholder="Enter off"/>
    <textarea name="summery" id="" cols="30"
              rows="10">@if(session("product")){{session("product")->summery}}@endif</textarea>
    <textarea name="details" id="" cols="30"
              rows="15">@if(session("product")){{session("product")->details}}@endif</textarea>
    <select name="category" id="">
        <?php
        function categoryIsNotParent(){
            $category=\Hosein\Products\CategoryProduct::select("*")->where("is_parent",0)->get();
            $selected="";

            foreach ($category as $value){
                if(session("product")){
                    $selected=(session("product")->category_id==$value->id)?"selected":"";
                }
                echo "<option value='$value->id' $selected>$value->name</option>";
            }
        }
        categoryIsNotParent();
        ?>
    </select>
    <input type="file" name="image">
    @if(session("product"))
        <img src="{{asset("/upload/")}}/{{session("product")->image}}" style="width:50px;height: 50px;" />
    @endif
    <input type="submit" name="send" value="send">
</form>
<hr>
<table border="1">
    <tr>
        <th>id</th>
        <th>image</th>
        <th>title</th>
        <th>create_time</th>
        <th>update_time</th>
        <th>edit</th>
        <th>del</th>
    </tr>
    @if(isset($listProduct))
        @foreach($listProduct as $item)
            <tr>
                <td>{{$item->id}}</td>
                <td><img src="{{asset("/upload/")}}/{{$item->image}}" style="width:50px;height: 50px;" /></td>
                <td>{{$item->title}}</td>
                <td>{{$item->created_at}}</td>
                <td>{{$item->updated_at}}</td>
                <td><a href="{{url("editProduct")}}/{{$item->id}}">edit</a></td>
                <td><a href="{{url("deleteProduct")}}/{{$item->id}}">del</a></td>
            </tr>
        @endforeach
    @endif

</table>