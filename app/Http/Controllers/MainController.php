<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Episode;
use App\Genre;
use App\Serie;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MainController extends Controller
{
    /**
     * Landing page !
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $mostViewed = $this->popular();
        $mostReviewed = $this->reviews();

        $mostRecent = Serie::orderBy('premiere', 'desc')
            ->take(4)->get();

        $genres = Genre::all();

        return view("index", compact("genres", "mostViewed", "mostReviewed", "mostRecent"));
    }

    /**
     * Popular series showed in the landing page
     */
    private function popular()
    {
        return DB::table("series")
            ->select(DB::raw("Count(*) as vues_count, series.id, series.nom, series.resume, series.note, series.premiere, series.image"))
            ->join("episodes", "series.id", "=", "episodes.serie_id")
            ->join("seen", "episodes.id", "=", "seen.episode_id")
            ->limit(4)
            ->groupBy("series.id", "series.nom", "series.resume", 'series.note', 'series.premiere', 'series.image')
            ->orderBy("vues_count", "desc")
            ->get();
    }

    /**
     * Most reviewed series in the landing page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    private function reviews()
    {
        return Serie::withCount('comments')
            ->orderBy('comments_count', 'desc')
            ->limit(4)
            ->get();
    }

    public function user()
    {
        if ($user = Auth::user()) {


            $data = array();

            if ($user->administrateur == 1) {
                $data["comVerif"] = Comment::where("validated", "=", 0)->select("*")->get();
            }


            $data["user"] = $user;

            $data["stats"] = array();

            // récupération nbr de épisodes vu ...
            $data["stats"]["epvu"] = DB::select(DB::raw("SELECT COUNT(*) AS nb FROM seen WHERE user_id=" . $user->id))[0]->nb;

            // récupération nbr de commentaires
            $data["stats"]["nbcomm"] = Comment::where("user_id", "=", $user->id)->count("*");

            // Récupération commentaires

            $data["comments"] = Comment::where("user_id", "=", $user->id)->select("*")->orderBy("serie_id")->get();

            // récupération des séries

            $data["series"] = Serie::all();

            // récupération séries vues

            //   $data["seriesvues"] = DB::table("seen")->select("id_serie")->where("user_id","=",$user->id)->get();

            $data["seriesvues"] = Episode::whereIn("id", DB::table("seen")->select("episode_id")->where("user_id", "=", $user->id))->select("serie_id")->groupBy("serie_id")->get();


            // Récupération durée passée
            $data["stats"]["duree"] = DB::select(DB::raw("SELECT SUM(duree)/60 AS somme FROM episodes JOIN seen ON episodes.id = seen.user_id WHERE seen.user_id = " . $user->id))[0]->somme;

            return view("auth.user", compact("data"));
        } else {
            return view("auth.login");
        }

    }


}
