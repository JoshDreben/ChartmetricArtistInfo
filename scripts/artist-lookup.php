<?php 

/**
 * Author: Josh Dreben
 * Date: 26 February 2020
 *
 * This class will display any artist's track list and 
 * how many playlists each song is on.
 */

class SpotifyChecker{
    // This object's authorization and refresh tokens
    private $_authtoken;
    private $_reftoken = "sBG7lfgzTI9kt7bYvpXsPVizANd6NHiL7wtIGcccjwCQdTJQb93M671Cs9muA11Q"; // NO LONGER ACTIVE
    private $_artistid;

    private $_artistname;
    private $_artistf;
    private $_artistml;

    /**
     * This function displays the artist's info for debugging purposes.
     *
     * @param $stats Artist statistics
     * @return none
     */
    public function displayStats($stats): void{
        echo $this->_artistname."<br>"."Followers: ".$this->_artistf."<br>"."Monthly Listeners: ".$this->_artistml."<br>";
    }


    /**
     * This function uses this object's refresh token to get the
     * Chartmetric authentication token
     *
     * @param none
     * @return Authentication Token
     */
    public function getAuthToken(): String{
        $curl = curl_init();
        $posData = array("refreshtoken" => $this->_reftoken);

        $options = array(CURLOPT_URL => "https://api.chartmetric.com/api/token",
            CURLOPT_POSTFIELDS => http_build_query($posData),
            CURLOPT_RETURNTRANSFER => true);
        curl_setopt_array($curl, $options);

        $response = curl_exec($curl);
        $json_response = json_decode($response);

        $auth_token = $json_response->token; // Authorization Token
        $this->_authtoken = $auth_token;
        curl_close($curl);
        return $auth_token;
    }


    /**
     * This function gets artist information based on their
     * Chartmetric ID and the Chartmetric API artist endpoint,
     * and assigns this artist object's artist fields to their
     * respective values.
     *
     * @param none
     * @return none
     */
    public function getTracks(){
        $curl = curl_init();
        $postData = array("Authorization" => $this::getAuthToken());

        $options = array(CURLOPT_URL => "https://api.chartmetric.com/api/artist/".$this->_artistid,
            CURLOPT_HTTPHEADER => array("Authorization: Bearer ".$this::getAuthToken()),
            CURLOPT_RETURNTRANSFER => true);
        curl_setopt_array($curl, $options);

        $response = curl_exec($curl);
        $json_response = json_decode($response);
        $artist = $json_response->obj;
        $stats = $artist->cm_statistics;

        $this->_artistname = $artist->name;
        $this->_artistf = $stats->sp_followers;
        $this->_artistml = $stats->sp_monthly_listeners;
        curl_close($curl);
    }

    /**
     * Returns this artist's name
     */
    public function getName(){
        return $this->_artistname;
    }

    /**
     * Returns this artist's followers
     */
    public function getFollowers(){
        return $this->_artistf;
    }

    /**
     * Returns this artist's monthly listeners
     */
    public function getMonthlyListeners(){
        return $this->_artistml;
    }

    /**
     * Default constructor for the SpotifyChecker object.
     * It assigns this object's artist id then calls getTracks()
     * to fill the rest of this artist's information.
     *
     * @param artistid Chartmetric ID of specific artist
     * @return this
     */
    public function __construct($artistid){
        $this->_artistid = $artistid;
        $this::getTracks();
    }
}
?>



