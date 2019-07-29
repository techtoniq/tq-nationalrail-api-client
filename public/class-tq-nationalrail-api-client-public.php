<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://www.techtoniq.com
 * @since      1.0.0
 *
 * @package    Tq_Nationalrail_Api_Client
 * @subpackage Tq_Nationalrail_Api_Client/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Tq_Nationalrail_Api_Client
 * @subpackage Tq_Nationalrail_Api_Client/public
 * @author     Matt Daniels <matt@techtoniq.com>
 */
class Tq_Nationalrail_Api_Client_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Tq_Nationalrail_Api_Client_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Tq_Nationalrail_Api_Client_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/tq-nationalrail-api-client-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Tq_Nationalrail_Api_Client_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Tq_Nationalrail_Api_Client_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/tq-nationalrail-api-client-public.js', array( 'jquery' ), $this->version, false );

	}
	

	/**
	 * The [tq_nationalrail] shortcode.
	 *
	 * @since    1.0.0
	 * @param    array    $atts       Shortcode attributes:
	 *                                'board_type'
	 *                                'station'
	 *                                'max_rows'
	 *                                'time_offset'
	 *                                'time_window'
	 */
	public function shortcode_nationalrail( $atts ) {
	
    	if ( ! is_array( $atts ) ) {
            $atts = [];
        }
        
        $atts = shortcode_atts( [
			'board_type'    => 'departure',
			'station'       => 'MKC',
			'max_rows'      => 20,
			'filter_type'   => 'from',
			'time_offset'   => 0,
			'time_window'   => 120,
			'api_token'     => 'fc2d6844-8aab-4c69-aecc-551ec3a4540f',
		], $atts );

        $request_params = array(
            'numRows'    => $atts['max_rows'], 
            'crs'        => $atts['station'], 
            'filterCrs'  => '', 
            'filterType' => $atts['filter_type'], 
            'timeOffset' => $atts['time_offset'], 
            'timeWindow' => $atts['time_window'],
            'api_token'  => $atts['api_token'],
        );
			            
		if ( ! empty( $atts['board_type'] ) ) {
			$data = $this->shortcode_nationalrail_query( $request_params );
			$output = $this->shortcode_nationalrail_format( $data );

			return $output;
		} else {
			return '';
		}        
	}
	
	/**
	 * Perform the web request to the National Rail API.
	 *
	 * @since    1.0.0
	 * @param      array    $request_params       API request parameters.
	 */
	private function shortcode_nationalrail_query( $request_params ) {
	    
        $wsdl = 'https://lite.realtime.nationalrail.co.uk/OpenLDBWS/wsdl.aspx?ver=2017-10-01';

		$options = array(
				'uri'=>'http://schemas.xmlsoap.org/soap/envelope/',
				'style'=>SOAP_RPC,
				'use'=>SOAP_ENCODED,
				'soap_version'=>SOAP_1_1,
				'cache_wsdl'=>WSDL_CACHE_NONE,
				'connection_timeout'=>15,
				'trace'=>true,
				'encoding'=>'UTF-8',
				'exceptions'=>true,
			);
		try {
			$client = new SoapClient($wsdl, $options);

			$token = $request_params['api_token'];
			$headerParams = array('ns2:TokenValue' => $token);
			$soapStruct = new SoapVar($headerParams, SOAP_ENC_OBJECT);
			$header = new SoapHeader('http://thalesgroup.com/RTTI/2010-11-01/ldb/commontypes', 'AccessToken', $soapStruct, false);
			$client->__setSoapHeaders($header);

			$data = $client->GetDepartureBoard($request_params);
		}
		catch(Exception $e) {
			die($e->getMessage());
		}
		
	    return $data;
	}
	
	/**
	 * Format the shortcode output.
	 *
	 * @since    1.0.0
	 * @param      array    $data       API response data.
	 */
	private function shortcode_nationalrail_format( $data ) {
	    
	    //echo '<pre>';
	    //var_dump( $data->GetStationBoardResult );
	    //echo '</pre>';
	    //return '';
	    
	    $html = "";
	    
	    //$html .= "<h5>" . $data->GetStationBoardResult->locationName . "</h5>";
	    
        $html .= "<table>";

    	$html .= "<thead>";
    	$html .= "<tr>";
    	$html .= "<th>Due</th>";
    	$html .= "<th>Destination</th>";
    	$html .= "<th>Status</th>";
    	$html .= "<th>Platform</th>";
    	$html .= "</tr>";
    	$html .= "</thead>";

    	$html .= "<tbody>";
		foreach ($data->GetStationBoardResult->trainServices->service as $service) {

            $destination = '';
			if( isset( $service->destination->location ) ) {
			    if( isset( $service->destination->location->locationName ) ) {
    			    
    			    $destination = $service->destination->location->locationName;
			    }
			}

			$platform = '';
			if( property_exists( $service, 'platform' )) $platform = $service->platform;

	    	$html .= "<tr>";
			$html .= "<td>$service->std</td>";
			$html .= "<td>$destination</td>";
			$html .= "<td>$service->etd</td>";
			$html .= "<td>$platform</td>";
			$html .= "</tr>";
		}

    	$html .= "</tbody>";
    	$html .= "</table>";	    

        $html .= "<ul>";
	    foreach( $data->GetStationBoardResult->nrccMessages->message as $msg ) {
	        $html .= "<li>" . reset( $msg ) . "</li>";
	    }
        $html .= "</ul>";

	    return $html;
	}
	
	

}
