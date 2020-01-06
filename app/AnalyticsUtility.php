<?php

namespace App;

use App\App;
use Analytics;
use Spatie\Analytics\Period;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class AnalyticsUtility extends Model
{
    public static function get_most_used_app($period = null)
    {
        $apps = App::with('category', 'category.section')->get();

        $collection = collect();

        foreach ($apps as $key => $app) {
            $string = $app->category->section->slug.'/'.$app->category->slug.'/'.$app->slug;
            $query = Analytics::performQuery($period, 'ga:sessions', [
                'dimensions' => 'ga:pagePath',
                'filters' => 'ga:pagePath=~/'.$string.'/*'
            ]);
            $results = $query->rows;
            $count = 0;
            foreach ($results as $key => $result) {
                $count = $count + $result[1];
            }
            $data = [
                'id' => $app->id,
                'name' => $app->title,
                'uri' => $string,
                'count' => $count,
            ];
            $collection->push($data);
        }

        return $collection;
    }

    public static function get_page_views($period = null)
    {
        $pageViewsTot = Analytics::performQuery($period, 'ga:pageviews');
        $pageViewsNoAdmin = Analytics::performQuery($period, 'ga:pageviews');

        return [
            'pageViews' => $pageViewsTot,
        ];
    }
}
