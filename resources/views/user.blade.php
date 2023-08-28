<!doctype html>
<html>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/form.js') }}" defer></script>
   
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        img{
            height: 50px;
            width: 50px;
        }
    </style>
</head>
<body>
    <div class="container p-3">
        <div class="text-center">
            <h1>USER INFO.</h1>
            <div id="alert_msg"></div>
        </div>

        <form action="" method="post">
            <!-- @csrf -->
            <div class="form-group p-2">
                <label for="name">Full Name</label>
                <input type="text" name="full_name" class="form-control" id="name" placeholder="eg. MAX KING">
                <div id="full_name-error" class="text-danger"></div>
            </div>
            <div class="form-group p-2">
                <label for="email">Email address</label>
                <input type="email" name="email" class="form-control" id="email" placeholder="eg. mas.king@test.com">
                <div id="email-error" class="text-danger"></div>
            </div>
            <div class="form-group p-2">
                <label for="mobile-number">Mobile Number</label>
                <input type="text" name="mobile" class="form-control" id="mobile-number" placeholder="eg. 888888888">
                <div id="mobile-error" class="text-danger"></div>
            </div>
            <div class="form-group p-2">
                <label for="country">Country</label>
                <select  name="country_code" class="form-control" id="country" data-attr="#other-country">
                    <option value="">Select Country</option>
                    <?php 
                    foreach ($country as $key => $value) {
                        echo '<option value="'.$value->id.'">'.$value->name.'</option>';
                    }
                    ?>
                    <option value="0">Other</option>
                </select>
                <input type="text" name="country_name" class="form-control" id="other-country" placeholder="eg. INDIA">
                <div id="country_code-error" class="text-danger"></div>
                <div id="country_name-error" class="text-danger"></div>
            </div>
            <div class="form-group p-2">
                <label for="state">State</label>
                <select name="state_code" class="form-control" id="state" data-attr="#other-state">
                    <option value="">Select State</option>
                    <option value="0">Other</option>
                </select>
                <input type="text" name="state_name" class="form-control" id="other-state" placeholder="eg. RAJASTHAN">
                <div id="state_code-error" class="text-danger"></div>
                <div id="state_name-error" class="text-danger"></div>
            </div>
            <div class="form-group p-2">
                <label for="city">City</label>
                <select name="city_code" class="form-control" id="city" data-attr="#other-city">
                    <option value="">Select City</option>
                    <option value="0">Other</option>
                </select>
                <input type="text" name="city_name" class="form-control" id="other-city" placeholder="eg. JAIPUR">
                <div id="city_code-error" class="text-danger"></div>
                <div id="city_name-error" class="text-danger"></div>
            </div>
            <div class="form-group p-2">
                <label for="Avatar">Profile Image</label>
                <input type="file" name="avatar" class="form-control" id="Avatar" placeholder="eg. MAX KING">
                <div id="avatar-error" class="text-danger"></div>
            </div>
            <div class="form-group p-2">
                <input type="submit" class="btn btn-lg btn-outline-success" id="name">
                <input type="reset" class="btn btn-lg btn-outline-secondary" id="name">
            </div>
        </form>
        <hr>
        <div class="">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                        <th>Avatar</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Mobile</th>
                        <th>Country</th>
                        <th>State</th>
                        <th>city</th>
                        <th>Created At</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            foreach ($users as $key => $value) {
                                echo '<tr><td><img src="'.asset('storage/'.$value['avatar']).'"/></td>
                                <td>'.$value['name'].'</td>
                                <td>'.$value['email'].'</td>
                                <td>'.$value['mobile'].'</td>
                                <td>'.$value['country'].'</td>
                                <td>'.$value['state'].'</td>
                                <td>'.$value['city'].'</td>
                                <td>'.$value['created_at'].'</td></tr>';
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    
</body>
</html> 