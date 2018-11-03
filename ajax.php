<?php

$allowed_urls = [
    'get-medicaments',
];

$home_path = dirname( dirname( dirname( dirname( __FILE__ ) ) ) );
require( $home_path . '/wp-blog-header.php' );

if( isset( $_GET[ 'page' ] ) && $_GET[ 'page' ] != '' ) {

    $page = $_GET[ 'page' ];

    if( array_search( $page, $allowed_urls ) !== false ) {

        header("HTTP/1.1 200 OK");
        processUrl( $page );

    } else {
        wp_die( 'Unauthorized access' );
    }
} else {
     wp_die( 'Unspecified query' );
}

function processUrl( $page )
{
    switch( $page ) {
        case 'get-medicaments':
            getMeds();
            break;
    }
}

function getMedStock( $med_id, $city = false ) {
    global $wpdb;
        
    $query = $wpdb->prepare( "
        SELECT ms.amount AS amount,
        mc.name AS company_name,
        mc.address AS address,
        mc.city AS city,
        mc.phone AS phone
        FROM {$wpdb->prefix}stocks AS ms
        JOIN {$wpdb->prefix}medicaments AS mm ON mm.id = ms.medicaments_id
        JOIN {$wpdb->prefix}companies AS mc ON mc.id = ms.companies_id
        WHERE ms.medicaments_id = %d", $med_id );
        
    $result = $wpdb->get_results( $query, ARRAY_A );
    return $result;
}

function getMeds() {
    $medicament = $_POST[ 'search_medicaments' ];
    $location = $_POST[ 'search_location' ];

    if( !empty( $medicament ) || !empty( $location ) ) {
        
        global $wpdb;
        $request = $wpdb->prepare( "SELECT id, name FROM {$wpdb->prefix}medicaments WHERE name = %s UNION SELECT id, name FROM {$wpdb->prefix}medicaments WHERE name LIKE '%%s%'", $medicament, $medicament );
        $result = $wpdb->get_results( $request, ARRAY_A );
        

        if( $result && count( $result ) ) {

            foreach( $result as $collection ) {

                $med_id = $collection['id'];
                
                echo '
                    <h1>' . $collection['name'] . '</h1>
                    <table id="table_search_results" class="hidden">
                        <thead>
                            <tr>
                                <th>Pharmacy</th>
                                <th>Location</th>
                                <th>Phone number</th>
                                <th>In stock</th>
                            </tr>
                        </thead>
                        <tbody id="table_results_body">';
                
                /*$arr = [
                    0 => [
                        'company_name' => 'Instituto Clínico de Aljustrel',
                        'address' => 'R. de Olivença nº 33<br>Aljustrel',
                        'phone' => '284 601 746',
                        'amount' => '20pcs',
                    ]
                ];*/
                $arr = getMedStock( $med_id );
                if( count( $arr ) ) {
                    foreach( $arr as $row ) {

                        echo '
                                <tr>
                                    <td><strong>' . $row[ 'company_name' ] . '</strong></td>
                                    <td><em>' . $row[ 'address' ] . '<br>' . $row[ 'city' ] . '</em></td>
                                    <td>' . $row[ 'phone' ] . '</td>
                                    <td><strong style="color: green;">' . $row[ 'amount' ] . ' pcs</strong></td>
                                </tr>';
                    }
                } else {
                    echo "
                                <tr>
                                    <td colspan='4' style='text-align: center;'><strong>Unforutnately, we couldn't find any matching results</strong></td>
                                </tr>";
                }
                echo '
                        </tbody>
                    </table>';
            }
        } else {
            echo 'false';
        }
    }
}