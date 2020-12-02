<?php
/**
 * Developed by Naufil khan.
 * Email: pisces_adnan@hotmail.com
 * Autour: Naufil khan
 * Date: 2/2/13
 * Time: 12:21 PM
 */

$where = '';
$business_type = 'All';

if (isset($_GET['submit_x']) || isset($_GET['submit'])) {

    if (getVar('country') != '') {
        $where .= " AND wtb.country='" . getVar('country') . "'";
    }
    if (getVar('city') != '') {
        $where .= " AND wtb.city='" . getVar('city') . "'";
    }
    if (getVar('area') != '') {
        $where .= " AND wtb.area='" . getVar('area') . "'";
    }
    if (getVar('business_type') != '') {
        $business_type = getVar('business_type');
        $where .= " AND wtb.business_type='" . getVar('business_type') . "'";
    }
}

$SQL = "SELECT wtb.* FROM cms_where_to_buy AS wtb WHERE `status`='Active' " . $where . ' ORDER BY wtb.ordering ASC';
$result = $this->db->query($SQL)->result();


$ip_country = file_get_contents('http://www.geoplugin.net/json.gp?ip=' . $this->input->server('REMOTE_ADDR'));
$ip_country = json_decode($ip_country);
$ip_country_name = $ip_country->geoplugin_countryName;

$countries = $this->db->query("SELECT id FROM cms_where_to_buy WHERE (country) ='" . ($ip_country_name) . "'");

if ($countries->num_rows > 0) {
    $_GET['country'] = $ip_country_name;
    $countries_lock = " AND countryName='" . $ip_country_name . "'";
}
if(empty($ip_country_name)) {$ip_country_name = 'Pakistan';}
$countries_lock = " AND countryName='" . $ip_country_name . "'";


$tab = getVar('tab');
?>

<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>


<div class="where_to_buy_container">

    <div class="tabbable">
        <ul class="nav nav-tabs nav-justified" role="tablist">
            <li class="<?= (($tab == 'find-location' || empty($tab)) ? 'active' : ''); ?>"><a href="#find-location" data-toggle="tab">Find a location</a></li>
            <li class="<?= (($tab == 'online-shopping') ? 'active' : ''); ?>"><a href="#online-shopping" data-toggle="tab">Online Shopping</a></li>
            <?php
            /*
             <li class="<?= (($tab == 'dealer-login') ? 'active' : ''); ?>"><a href="#dealer-login" data-toggle="tab" class="">Dealer Login</a></li>
             */
            ?>
        </ul>
        <div class="tab-content with-padding">
        <div id="find-location" class="tab-pane fade in <?= (($tab == 'find-location' || empty($tab)) ? 'active' : ''); ?>">
            <p>&nbsp;</p>
            <form action="" method="get" id="search_wtb">
                <div class="row">
                    <!--<div class="col-sm-3"><strong>Enter your Country</strong></div>-->
                    <div class="col-sm-4"><strong>Enter your City</strong></div>
                    <div class="col-sm-4"><strong>Enter your Area</strong></div>
                    <div class="col-sm-2"><strong>Dealer Type</strong></div>
                    <div class="col-sm-2"></div>
                </div>
                <div class="row">
                    <!--<div class="col-sm-3">
                        <select name="country" id="country" class="select-search">
                            <option value="">Select your Country</option>
                            <?php /*echo selectBox("SELECT countryName,`countryName` as show_short_name from countries WHERE 1 " . $countries_lock, getVar('country')); */?>
                        </select>
                    </div>-->
                    <div class="col-sm-4">
                        <select name="city" id="city" class="select-search">
                            <option value="">Select your city</option>
                            <?php
                            if (getVar('country') != '') {
                                $city_where = " AND country='" . getVar('country') . "'";
                            }
                            echo selectBox("SELECT `city`, city AS show_city FROM `cms_where_to_buy` WHERE `status`='Active' " . $city_where . " GROUP BY city", getVar('city')); ?>
                        </select>
                    </div>
                    <div class="col-sm-4">
                        <select name="area" id="area" class="select-search">
                            <option value="">Select area</option>
                            <?php
                            if (getVar('city') != '') {
                                $area_where = " AND city='" . getVar('city') . "'";
                            }
                            echo selectBox("SELECT `area`, area AS show_area FROM `cms_where_to_buy` WHERE `status`=1 " . $city_where . $area_where . " GROUP BY area", getVar('area'));
                            ?>
                        </select>
                    </div>
                    <div class="col-sm-2">
                        <select name="business_type" id="business_type" class="select-full">
                            <option value="">All</option>
                            <?php
                            echo selectBox(get_enum_values('cms_where_to_buy', 'business_type'), getVar('business_type'));
                            ?>
                        </select>
                    </div>
                    <div class="col-sm-2 text-center">
                        <input type="submit" name="submit" class="btn btn-inovi" value="Submit"/>
                    </div>
                </div>
            </form>
            <p>&nbsp;</p>

            <p class="height-15">&nbsp;</p>

            <div class="row">
                <div class="col-sm-12">
                    <div class="tabbable">
                        <ul class="nav nav-tabs nav-justified" role="tablist">
                            <li class="active"><a href="#on-list" data-toggle="tab" class=""><?php echo (getVar('business_type') == '' ? 'All' : getVar('business_type')); ?> List</a></li>
                            <li><a href="#on-map" data-toggle="tab" class="">Find On Map</a></li>
                        </ul>
                        <div class="tab-content">
                            <div id="on-map" class="tab-pane fade in">
                                <div id="map-canvas" style="min-height: 400px;"></div>
                            </div>
                            <div id="on-list" class="tab-pane fade in active">
                                <?php
                            if (isset($_GET['submit_x']) || isset($_GET['submit'])) {
                                if (count($result) > 0) {
                                ?>
                                <div class="row">
                                <div class="map-address-li square-group">
                                <?php
                                foreach ($result as $i => $row) {
                                    ?>
                                    <div class="col-sm-4">
                                    <div class="square-box">
                                        <h3 class="number-block"><?= $row->business_name; ?></h3><br>
                                        <?= stripslashes($row->business_address); ?> <br>
                                        <?php
                                        echo stripslashes($row->office_desc);
                                        ?>
                                    </div>
                                    </div>
                                <?php
                                }
                                echo '</div></div>';
                                }
                            } else {
                                echo '<h4 style="text-align: center">Please enter your location above</h4>';
                            }
                            ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="online-shopping" class="tab-pane fade in <?= (($tab == 'dealer-login') ? 'active' : ''); ?>">
            <div class="clearfix"></div>
            <p>&nbsp;</p>
            <?php
            $Online_Shopping = get_page(null, "AND pages.friendly_url = 'online-shopping'");
            if($Online_Shopping)
                echo do_shortcode(stripslashes($Online_Shopping->content));
            ?>
        </div>
                <?php /*
        <div id="dealer-login" class="tab-pane fade in">
            <?php
            if ($this->session->userdata('frontend_user_id')) {
                include "dealer_area.php";
            }else{
                include "login.php";
            }
            ?>
        </div>
    */?>
    </div>
</div>
</div>


<script type="text/javascript">
    (function ($) {
        $(document).ready(function () {


            $('.tabs-ul a').on('click', function (e) {
                e.preventDefault();
                var href = $(this).attr('href');
                var href = href.substr(1, href.length);
                $('div[id*=tab]').hide(0);
                $('div#' + href).show(0)
                $('.tabs-ul a').removeClass('active');
                $(this).addClass('active');

            });

            $('#country').on('change', function () {
                var country = $(this).val()
                $.ajax({
                    type: "POST",
                    url: "<?=site_url('AJAX/?action=WtoB_city');?>",
                    data: {country: country},
                    complete: function (data) {
                        //alert(data.responseText);
                        $('#city').html(data.responseText)
                        $('#city_chzn').remove();
                        $('#city').removeClass('chzn-done');
                        $('#city').select();
                    }
                });
            });

            $('#city').on('change', function () {
                var city = $(this).val()
                $.ajax({
                    type: "POST",
                    url: "<?=site_url('AJAX/?action=WtoB_area');?>",
                    data: {city: city},
                    complete: function (data) {
                        //alert(data.responseText);
                        $('#area').html(data.responseText)
                        $('#area_chzn').remove();
                        $('#area').removeClass('chzn-done');
                        $('#area').select();
                    }
                });
            });

            $('.type_dealer a').on('click', function (e) {
                e.preventDefault();
                $('#business_type').attr('value', $(this).attr('href'));
                $('#search_wtb').submit();
            });

            var hash = window.location.hash;
            hash && $('ul.nav a[href="' + hash + '"]').tab('show');

        });
    })(jQuery)
</script>
<script>
    var map = null;
    function initialize() {

        var myLatlng = new google.maps.LatLng(24.904694, 67.030372);
        var mapOptions = {
            zoom: 10,
            center: myLatlng,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            styles: [{ featureType: 'water', stylers: [{color: '#46bcec'}, {visibility: 'on'}]}, {featureType: 'landscape', stylers: [{color: '#f2f2f2'}]}, { featureType: 'road', stylers: [{saturation: -100}, {lightness: 45}]}, {featureType: 'road.highway', stylers: [{visibility: 'simplified'}]}, { featureType: 'road.arterial', elementType: 'labels.icon', stylers: [{visibility: 'off'}]}, { featureType: 'administrative', elementType: 'labels.text.fill', stylers: [{color: '#444444'}]}, {featureType: 'transit', stylers: [{visibility: 'off'}]}, { featureType: 'poi', stylers: [{visibility: 'off'}]}]


        };

        map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

        var georssLayer = new google.maps.KmlLayer('<?=site_url('getgeorss/geoRSS/?country='.getVar('country').'&city='.getVar('city').'&business_type='.getVar('business_type').'&rnd='.rand());?>');

        console.log('<?=site_url('getgeorss/geoRSS/?country='.getVar('country').'&city='.getVar('city').'&area='.getVar('area').'&business_type='.getVar('business_type').'&rnd='.rand());?>');
        georssLayer.setMap(map);
    }

    (function ($) {
        $(document).ready(function () {
            $(document).on( 'shown.bs.tab', 'a[data-toggle="tab"]', function (e) {
                // activated tab

                if($(e.target).attr('href') == '#on-map'){
                    initialize();
                }
            })

            google.maps.event.addDomListener(window, "resize", function () {
                var center = map.getCenter();
                google.maps.event.trigger(map, "resize");
                map.setCenter(center);
            });

        });
    })(jQuery)
</script>