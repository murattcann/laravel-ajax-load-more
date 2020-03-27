<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Load more data with ajax in laravel</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" />
</head>
<body>
<div class="container mt-4">
    <h3 class="mb-4 border-bottom pb-1">Product List</h3>
    <div class="row product-list">
        @if(count($products)>0)
            @foreach($products as $data)
                <div class="col-sm-4 mb-3 product-box">
                    <img src="{{ $data->image }}" class="card-img-top" alt="{{ $data->title }}" />
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $data->id }}. {{ $data->title }}</h5>
                            <p class="card-text">{{ \Illuminate\Support\Str::limit($data->description, 70, "...")}}</p>
                            Price: <span class="badge badge-secondary">$ {{ $data->price }}</span>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
    @if(count($products)>0)
        <p class="text-center mt-4 mb-5"><button class="load-more btn btn-dark" data-total-result="{{ App\Product::count() }}">Load More</button></p>
    @endif
</div>
</body>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>


<script type="text/javascript">
    $(document).ready(function(){

        $(".load-more").on('click',function(){

            var $currentResultCount=$(".product-box").length;

            // Ajax Reuqest
            $.ajax({
                url: "{{route('load-more')}}",
                type: "get",
                dataType: "json",
                data: {currentResultCount: $currentResultCount},
                beforeSend: function () {
                    $('.load-more').html('Loading...');
                },
                success: function (response) {
                    var html = '';
                    var $description = '';

                    $.each(response, function (index, value) {

                        html+= '<div class="col-sm-4 mb-3 product-box">';
                            html+= '<img src="'+value.image+'" class="card-img-top" alt="'+value.title+'" />';
                            html+= '<div class="card">';
                                html+= '<div class="card-body">';
                                    html+= '<h5 class="card-title">'+value.id + " " + value.title + '</h5>';
                                    html+= '<p class="card-text">'+strLimit($description, 70, "...")+'</p>';
                                    html+= 'Price: <span class="badge badge-secondary">$'+value.price+'</span>';
                                html+= ' </div>';
                            html+= ' </div>';
                        html+= ' </div>';
                    });

                    $(".product-list").append(html);

                    var $currentTotalResult =  $('.product-box').length;
                    var $totalResult =$('.load-more').data('total-result');
                    console.log($currentTotalResult);
                    console.log($totalResult);
                    if($currentTotalResult == $totalResult) {
                        $('.load-more').remove();
                    }else{
                         $('.load-more').html('Load More')
                    }
                }
            });
            function strLimit(text, count, end = "..."){
                return text.slice(0, count) + (((text.length > count) && end) ? end : "");
            }

        });
    });
</script>
</html>
