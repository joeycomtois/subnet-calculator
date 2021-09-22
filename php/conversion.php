<?php 

session_start();


$input_address = $_POST['address'];
$prefix = $_POST['prefix'];
$protocol = $_POST['protocol'];

$illegal_address = 0;
$address_split = explode('.', $input_address);

if (count($address_split) != 4) {
    $illegal_address = 1;
}

$input_address_sanitized = "";

for ($i=0; $i<count($address_split); $i++) {
    if (intval($address_split[$i]) > 255) {
        $illegal_address = 1;
    } else {
        $input_address_sanitized .= strval(intval($address_split[$i]) + 0);

        if ($i + 1 != count($address_split)) {
            $input_address_sanitized .= ".";
        }
    }


    
}

$input_address = $input_address_sanitized;


function addressToHex($address) {

    $exploded_address = explode('.', $address);
    $address_hex = "";

    for ($i=0; $i<count($exploded_address); $i++) {
        $hex_value = dechex($exploded_address[$i]);
    
        if (strlen($hex_value) == 1) {
            $hex_value = "0" . $hex_value;
        }
    
    
        $address_hex .= $hex_value;
    
    
        if ($i + 1 != count($exploded_address)) {
            $address_hex .= ".";
        }
    }

    return strtoupper($address_hex);
}


function subnetMask($address) {

    $exploded_address = explode('.', $address);
    $subnet_mask_address = "";
    $netmask_counter = $_POST['prefix'];


    // For each byte in address
    for ($i=0; $i<4; $i++) {
        $byte = "00000000";
        
        $byte_split = str_split($byte);

        for ($j=0; $j<8; $j++) {
            if ($netmask_counter != 0) {
                $byte_split[$j] = "1";
                $netmask_counter -= 1;
            } else {
                $byte_split[$j] = "0";
            }
            
        }

        $byte = join($byte_split);

        $subnet_mask_address .= bindec($byte);

        if ($i + 1 != 4) {
            $subnet_mask_address .= ".";
        }
    }

    return $subnet_mask_address;
}

function wildcard($address) {

    $exploded_address = explode('.', $address);
    $subnet_mask_address = "";
    $netmask_counter = $_POST['prefix'];
    $all_bytes_array = [];


    // For each byte in address
    for ($i=0; $i<4; $i++) {
        $byte = "00000000";
        
        $byte_split = str_split($byte);
        
        for ($j=0; $j<8; $j++) {
            if ($netmask_counter != 0) {
                $byte_split[$j] = "1";
                $netmask_counter -= 1;
            } else {
                $byte_split[$j] = "0";
            }
            
        }
        $byte = join($byte_split);

        array_push($all_bytes_array, $byte);
    }

    $all_bytes_array = array_reverse($all_bytes_array);
    
    for ($i=0; $i<count($all_bytes_array); $i++) {
        
        $subnet_mask_address .= bindec($all_bytes_array[$i]);

        if ($i + 1 != count($all_bytes_array)) {
            $subnet_mask_address .= ".";
        }

    }

   



    return $subnet_mask_address;
}


if ($illegal_address == 0) {
    $_SESSION['address'] = $_POST['address'];
    $_SESSION['prefix'] = $_POST['prefix'];
    $_SESSION['protocol'] = $_POST['protocol'];
    $_SESSION['input'] = $input_address . "\\" . stripcslashes($prefix);
    $_SESSION['input_long'] = ip2long($input_address);
    $_SESSION['input_ip'] = $input_address;
    $_SESSION['input_hex'] = addressToHex($input_address);
    $_SESSION['CIDR'] = "-";
    $_SESSION['CIDR_long_range'] = "-";
    $_SESSION['CIDR_ip_range'] = "-";
    $_SESSION['CIDR_hex_range'] = "-";
    $_SESSION['ips_in_range'] = "-";
    $_SESSION['mask_bits'] = stripcslashes($prefix);
    $_SESSION['subnet_mask'] = subnetMask($input_address);
    $_SESSION['hex_subnet_mask'] = addressToHex(subnetMask($input_address));
    $_SESSION['wildcard'] = wildcard($input_address);

    $_SESSION['calculated'] = 1;

    header("location: /");


    echo($_SESSION['input']);
    echo($_SESSION['input_long']);
    echo($_SESSION['input_ip']);
    echo($_SESSION['input_hex']);
    echo($_SESSION['CIDR']);
    echo($_SESSION['CIDR_long_range']);
    echo($_SESSION['CIDR_ip_range']);
    echo($_SESSION['CIDR_hex_range']);
    echo($_SESSION['ips_in_range']);
    echo($_SESSION['mask_bits']);
    echo($_SESSION['subnet_mask']);
    echo($_SESSION['hex_subnet_mask']);

    $_SESSION['error_message'] = "";
} else {

    $_SESSION['error_message'] = "The address entered was illegal. " . $input_address;
    header("location: /");
}

















?>