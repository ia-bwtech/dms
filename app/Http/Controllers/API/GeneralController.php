<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class GeneralController extends Controller
{
    //
    public function handicapper_featured(Request $request){
        $users = User::where("is_handicapper", 1)->with(["bets" => function($query){
            $query->where("is_verified", 1)->where("status", 0)->where("is_won", '!=', 2);
        }])->get();
        $featuredCollection = collect();
        $rank = 1;
        foreach ($users as $user){
            if ($user->bets->isNotEmpty()){
                $totalBets = 0;
                $wins = 0;
                $units = 0;
                $netUnits = 0;
                $risk = 0;
                foreach ($user["bets"] as $bet){
                    $wins += $bet->is_won;
                    $totalBets += 1;
                    $risk += $bet->risk;
                    if ($bet->is_won == 1){
                        $netUnits += $bet->to_win;
                        $units += $bet->to_win;
                    }else{
                        $netUnits -= $bet->risk;
                        $units -= $bet->rishk;
                    }
                }
                $winLossPercentage = $totalBets > 0 ? ($wins / $totalBets) * 100 : '-';
                $losses = $totalBets - $wins;
                $roi = $risk > 0 ? ($units / $risk) * 100 : '-';
                $_user_data = [
                    "rank" => $rank,
                    "user_id" => $user->id,
                    "name" => $user->name,
                    "image" => $user->image_with_path,
                    "win_loss_percentage" => round($winLossPercentage, 2),
                    "total_bets" => $totalBets,
                    "wins" => $wins,
                    "losses" => $losses,
                    "net_units" => round($netUnits, 2),
                    "roi" => round($roi, 2)
                ];
                $featuredCollection->push($_user_data);
                $rank++;
            }
        }
        $this->jsonResponseData["data"] = $featuredCollection->sortByDesc("total_bets")->sortByDesc("roi")->paginate(5);
        return $this->jsonResponse();
    }

    public function packages(Request $request)
    {
        $users = User::has('packages', '>', 0)->with('packages')->orderBy('verified_win_loss_percentage', 'desc')->get();
        if (isset($request->sortBy)) {
            $users = User::has('packages', '>', 0)->with('packages')->orderBy($request->orderBy, $request->sortBy)->get();
        }
        if (isset($request->search)) {
            $users = User::has('packages', '>', 0)->with('packages')->where('name', 'like', '%' . $request->search . '%')->get();
        }
        $userWithPackages = [];
        foreach ($users as $user){
            $userPackage = [];


            foreach ($user->packages as $package){
                $userPackage[] = [
                    "id" => $package->id,
                    "name" => $package->name,
                    "price" => $package->price,
                    "description" => $package->description,
                    "duration" => $package->duration,
                    "from_date" => $package->from_date,
                    "to_date" => $package->to_date,
                    "status" => $package->status,
                    "is_admin" => $package->is_admin,
                ];
            }
            $userWithPackages[] = [
                "id" => $user->id,
                "name" => $user->name,
                "email" => $user->email,
                "phone" => $user->phone,
                "bio" => $user->bio,
                "image" => $user->image_with_path,
                "packages" => $userPackage
            ];
        }


        $this->jsonResponseData["status"] = true;
        $this->jsonResponseData["data"] = $userWithPackages;
        return $this->jsonResponse();

    }


    public function testApi(){

        $this->jsonResponseData["message"] = "Testing request";
        return $this->jsonResponse();
    }

}
