<?php

/**
 * Class Getgeorss
 * @property m_property $property
 */
class Getgeorss extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    function geoRSS()
    {

        ob_start();
        header('Cache-Control: no-cache, must-revalidate');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        //header('Content-type: application/atom+xml; charset=utf-8');
        header('Content-type: application/vnd.google-earth.kml+xml; charset=utf-8');

        ?><kml xmlns="http://www.opengis.net/kml/2.2">
            <Document>
                <Style id="sony_centers">
                    <IconStyle>
                      <Icon>
                        <href><?=asset_url('front/uploads/sony_centers.png');?></href>
                      </Icon>
                    <animation>DROP</animation>
                    </IconStyle>
                </Style>
                <Style id="wholesale">
                    <IconStyle>
                      <Icon>
                        <href><?=asset_url('front/uploads/wholesale.png');?></href>
                      </Icon>
                        <animation>DROP</animation>
                    </IconStyle>
                </Style>
                <Style id="retail">
                    <IconStyle>
                      <Icon>
                        <href><?=asset_url('front/uploads/retail.png');?></href>
                      </Icon>
                    <animation>DROP</animation>
                    </IconStyle>
                </Style>
            <?php
                /*------------------------------------------------------------------------------------------------------------*/
                $where = '';
                if(getVar('country') != ''){
                    $where .= "AND country='".getVar('country')."'";
                }
                if(getVar('city') != ''){
                    $where .= "AND city='".getVar('city')."'";
                }
                if(getVar('area') != ''){
                    $where .= "AND area='".getVar('area')."'";
                }
                if(getVar('business_type') != ''){
                    $where .= "AND business_type='".getVar('business_type')."'";
                }

                $sql = "SELECT * FROM cms_where_to_buy WHERE 1 " . $where;

                $query = $this->db->query($sql);
                if ($query->num_rows() > 0) {

            foreach ($query->result() as $row) {

                $geoLat = $row->lat;
                $geoLon = $row->lng;
                $coords = $geoLon . ',' . $geoLat;


                if ($geoLat && $geoLon) {

                    ?><Placemark>
                        <name><![CDATA[<?= $row->business_name . ' - ' . $row->business_type; ?>]]></name>
                        <description><![CDATA[
                            <div class="window">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <!--<h3 class="color-1"><?php /*echo $row->business_name; */?></h3>-->
                                        <p><?php echo $row->business_address; ?></p>
                                        <p><?php echo stripslashes($row->office_desc); ?></p>
                                    </div>
                                </div>
                            </div>
                            ]]>
                        </description>
                        <?php
                        if($row->business_type == 'Sony Center'){
                            echo '<styleUrl>#sony_centers</styleUrl>';
                        }elseif($row->business_type == 'Wholesale'){
                            echo '<styleUrl>#wholesale</styleUrl>';
                        }else{
                            echo '<styleUrl>#retail</styleUrl>';
                        }
                        ?>
                        <Point>
                            <coordinates><?php echo $coords ?></coordinates>
                        </Point>
                    </Placemark>
                <?php
                }
            }
        ?></Document>
</kml><?
        echo $feed = ob_get_clean();

        }

    }
}