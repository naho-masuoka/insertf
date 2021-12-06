<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <title>Insert_F</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
    </head>

    <body>
    
    <div class="container">
        <div class="center jumbotron mt-5" style="background-color:#A1E0CB;width:100%;height:40em;display:d-flex;justify-content:center;align-items: center;">
 
            <p class="lead text-center" style="color:#666666;font-weight:bold;">各部署が保有する大切な資産を</p>
            <p class="lead text-center" style="color:#666666;font-weight:bold;">いつでもどこでも共有し</p>
            <p class="lead text-center" style="color:#666666;font-weight:bold;">迅速かつ安全に情報共有を可能に</p>

            <h1 class="display-4 mb-4 text-center" style="color:#71685C;font-weight:bold">Insert File</h1>
            <div class="text-center mb-3">
            @guest   
                <div class="d-inline-flex row">    
                    <a class="btn btn-lg mr-4" style="background-color:#666666;color:#A1E0CB;box-shadow: 5px 5px 5px #666666;" href="\register" role="button">Sign Up</a>
                    <a class="btn btn-lg" style="background-color:#666666;color:#A1E0CB;box-shadow: 5px 5px 5px #666666;" href="\login" role="button">Sign In</a>
                </div>
                @else
                <a class="btn btn-lg" style="background-color:#666666;color:#A1E0CB;box-shadow: 5px 5px 5px #666666;" href="\list" role="button">Log In</a>
            @endguest
            </div>
                <hr class="my-4 mb-5">
            <div class="text-center mb-3">
            <h1 class="display-4 mb-4 text-center" style="color:#71685C;font-weight:bold">N's</h1>
            </div>
            <h6 class="mb-4 text-center" style="color:#666666;font-weight:bold;">世界水準のＩＴソリューションを</h6>
            <h6 class="mb-4 text-center" style="color:#666666;font-weight:bold;">実現できるパートナーを目指して</h6>
        </div>
    </div>

        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>
        <script defer src="https://use.fontawesome.com/releases/v5.7.2/js/all.js"></script>
    </body>
</html>