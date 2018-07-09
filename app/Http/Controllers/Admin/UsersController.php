<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\User as UserMod;
use App\Model\Shop as ShopMod;
use App\Model\product as ProductMod;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         //$shop = ProductMod::find(1)->shop;
         //echo "<br/>Product is belongs to Shop :".$shop->user->name;
         
        //$products = App\Model\Shop::find(1)->products;
            //$products = ShopMod::find(1)->products;
            //dd($products);
            //foreach ($products as $item) {
                //dd($item);exit;
                //echo "<br/> Product :".$item->name." : ".$item->desc;
            

        //$shop = ShopMod::find(1);
         //echo "<br />Shop name :".$shop->name;
         //echo "<br />Shop is belongs to :".$shop->user->name;
         //$mods = UserMod::all();
        
        // Using alias name
        /*$modsX = UserMod::all();

        foreach ($modsX as $itemxx) {
            echo $itemxx->name." : ".$itemxx->email."<br />";
        }
        $mods = UserMod::where('active', 1)
               ->where('city','bangkok')
               ->where('name','like','%user2%')
               ->get();
        foreach ($mods as $item) {
            echo $item->name." : ".$item->email."<br/>";
        }

        $mod = UserMod::find(1);
        echo "Name :".$mod->name."<br/><br/>";

        $mods = UserMod::find([1, 3, 4]);
        foreach($mods as $item){
            echo $item->name." : ".$item->email."<br/>";
        }
        $count = UserMod::where('active', 1)->count();
        echo "Count".$count;
        $max = UserMod::where('active', 1)->max('age');
        echo "<br/>Age Max".$max;
        $user = UserMod::find(1);
        echo "<br />User name :".$user->name;
    
        $shop = UserMod::find(1)->shop;
        echo "<br />Shop name :".$shop->name;

        $user = UserMod::find(99);
        echo "<br />Shop name2 :".$user->shop->name;*/

         /*$data = [
            'name' => 'My Name',
            'surname' => 'My SurName',
            'email' => 'myemail@gmail.com'
        ];

        $item = [
            'item1' => 'My Value1',
            'item2' => 'My Value2'
        ];

        $results = [
            'data' => $data,
            'item' => $item
        ];

        return view('template', $results);*/

         $mods=UserMod::paginate(5);
        return view('admin.user.lists',compact('mods'));




    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

         request()->validate([
            'name' => 'required|min:2|max:50',
            'surname' => 'required|min:2|max:50',
            'mobile' => 'required|numeric',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'confirm_password' => 'required|min:6|max:20|same:password',
        ], [
            'name.required' => 'Name is required',
            'name.min' => 'Name must be at least 2 characters.',
            'name.max' => 'Name should not be greater than 50 characters.',
        ]); 
        
        $mod = new UserMod;
     
        $mod->email = $request->email;
        $mod->password = bcrypt($request->password);
        $mod->name = $request->name;
        $mod->surname = $request->surname;
        $mod->mobile = $request->mobile;
        $mod->age = $request->age;
        $mod->address = $request->address;
        $mod->city = $request->city;
        $mod->save();

        return redirect('admin/users')->with('success','User['.$request->name.']create successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
         $item = UserMod::find($id);
        //dd($item);
        return view('admin.user.edit', compact('item'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $id)
    {
        $request->validated();
        $mod = UserMod::find($id);
        $mod->name     = $request->name;
        $mod->surname  = $request->surname;
        //$mod->email    = $request->email;
        $mod->mobile   = $request->mobile;
        $mod->surname  = $request->surname;
        $mod->age      = $request->age;
        $mod->address  = $request->address;
        $mod->city     = $request->city;
        $mod->save();
        return redirect('admin/user')
                    ->with('success', 'User ['.$request->name.'] updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $mod = UserMod::find($id);
        $mod->delete();
        return redirect('admin/user')
                ->with('success', 'User ['.$mod->name.'] deleted successfully.');
    }
}
