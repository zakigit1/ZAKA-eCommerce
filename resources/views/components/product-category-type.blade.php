@php

    $lastkey = [];
    // $cat_type = '';

    foreach ($catdata as $categoryType => $value) {
        //category type mean : sub_category or child_category

        if ($value === null) {
            break;
        }

        $lastkey = [$categoryType => $value];
    }

    // dd($lastkey);
    // dd(array_keys($lastkey)[0]);

    if (array_keys($lastkey)[0] == 'category') {
        $cat_type = \App\Models\Category::find($lastkey['category']);
        $products = \App\Models\Product::withAvg('reviews','rating')
            ->withCount('reviews')
            ->with([        
                'gallery',
                'category',
                'reviews'=>function($query){
                    $query->where('status',1);
                },
                'variants'=>function($query){
                    $query->with(['items' => function ($q) {
                                $q->where('status', 1);
                                },
                        ])->where('status',1);
                }])
            ->where('category_id', $cat_type->id)
            ->orderBy('id', 'DESC')
            ->get();

    } elseif (array_keys($lastkey)[0] == 'sub_category') {
        $cat_type = \App\Models\Subcategory::find($lastkey['sub_category']);
        $products = \App\Models\Product::withAvg('reviews','rating')
            ->withCount('reviews')
            ->with([
                'gallery',
                'category',
                'reviews'=>function($query){
                    $query->where('status',1);
                },
                'variants'=>function($query){
                    $query->with(['items' => function ($q) {
                                $q->where('status', 1);
                                },
                        ])->where('status',1);
                }])
            ->where('sub_category_id', $cat_type->id)
            ->orderBy('id', 'DESC')
            ->get();

    } elseif (array_keys($lastkey)[0] == 'child_category') {
        $cat_type = \App\Models\Childcategory::find($lastkey['child_category']);
        $products = \App\Models\Product::withAvg('reviews','rating')
            ->withCount('reviews')
            ->with([
                'gallery',
                'category',
                'reviews'=>function($query){
                    $query->where('status',1);
                },
                'variants'=>function($query){
                    $query->with(['items' => function ($q) {
                                $q->where('status', 1);
                                },
                        ])->where('status',1);
                }])
            ->where('child_category_id', $cat_type->id)
            ->orderBy('id', 'DESC')
            ->get();
    }

    // dd($cat_type->name);

@endphp