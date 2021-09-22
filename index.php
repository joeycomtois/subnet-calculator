<?php 

    session_start();


    $input = "-";
    $input_long = "-";
    $input_ip = "-";
    $input_hex = "-";
    $CIDR = "-";
    $CIDR_long_range = "-";
    $CIDR_ip_range = "-";
    $CIDR_hex_range = "-";
    $ips_in_range = "-";
    $mask_bits = "-";
    $subnet_mask = "-";
    $hex_subnet_mask = "-";
    $wildcard = "-";
    $use_address = "";
    $error_message = "";
    $placeholder_text_address = '10.0.0.1';

    if (isset($_SESSION['error_message'])) {
        if ($_SESSION['error_message'] != "") {
            $placeholder_text_address = $_SESSION['error_message'];
        }
    }

    if (isset($_SESSION['calculated'])) {
        if ($_SESSION['calculated'] == 1) {
            $input = $_SESSION['input'];
            $input_long = $_SESSION['input_long'];
            $input_ip = $_SESSION['input_ip'];
            $input_hex = $_SESSION['input_hex'];
            $CIDR = $_SESSION['CIDR'];
            $CIDR_long_range = $_SESSION['CIDR_long_range'];
            $CIDR_ip_range = $_SESSION['CIDR_ip_range'];
            $CIDR_hex_range = $_SESSION['CIDR_hex_range'];
            $ips_in_range = $_SESSION['ips_in_range'];
            $mask_bits = $_SESSION['mask_bits'];
            $subnet_mask = $_SESSION['subnet_mask'];
            $hex_subnet_mask = $_SESSION['hex_subnet_mask'];
            $wildcard = $_SESSION['wildcard'];

            $use_address = $_SESSION['address'];
            $use_netmask = $_SESSION['prefix'];
            $use_protocol = $_SESSION['protocol'];



        }
    } 

    $_SESSION['calculated'] = 0;
    $_SESSION['error_message'] = "";

?>

<!DOCTYPE html>

<html lang="en">
    <head>
        <link href="/style.css" rel="stylesheet">
        <script src="/script.js"></script>
    </head>
    
    <body>
        <div class="header">
            <h1>Subnet Calculator</h1>
        </div>

        <div class="data-input">
            <form method="post" action="/php/conversion.php">

                <div class="address">
                    <h3>Address</h3>
                    <input class="data-input-text" required type="text" name="address" placeholder="<?php echo($placeholder_text_address ); ?>" value="<?php echo($use_address); ?>">
                </div>
                
                <div class="prefix">
                    <h3>Netmask</h3>
                    <select class="ui search dropdown" name="prefix">
                        <?php 
                        for ($i=1; $i<33; $i++) {
                            echo('<option value="' . $i . '">\\' . $i .'</option>');
                        }
                        ?>
                    </select>   
                </div>

                <div class="protocol">
                    <h3>Protocol</h3>
                    <select class="ui search dropdown" name="protocol">
                        <option value="IPv4">IPv4</option>
                        <option value="IPv6">IPv6</option>
                        <option value="Subnet">Subnet Mask</option>
                    </select>   
                </div>

                <div class="submit">
                    <input class="data-input-submit" type="submit" value="Calculate">
                </div>
            </form>


        </div>

        <div class="data-receive">
            <div class="data-row">
                <button class="data-instance" onclick="copyToClipboard(1)">
                    <div class="data-instance-title">
                        <h1>Input</h1>
                        <div class="data-instance-copy-img">
                            <img src="/img/icon/clipboard-copy.png">
                        </div>
                    </div>
                    <div class="data-value">
                        <p id="1"><?php echo($input); ?></p>
                    </div>
                </button>
                <button class="data-instance" onclick="copyToClipboard(2)">
                    <div class="data-instance-title">
                        <h1>Input Long</h1>
                        <div class="data-instance-copy-img">
                            <img src="/img/icon/clipboard-copy.png">
                        </div>
                    </div>
                    <div class="data-value">
                        <p id="2"><?php echo($input_long); ?></p>
                    </div>
                </button>
                <button class="data-instance" onclick="copyToClipboard(3)">
                    <div class="data-instance-title">
                        <h1>Input IP</h1>
                        <div class="data-instance-copy-img">
                            <img src="/img/icon/clipboard-copy.png">
                        </div>
                    </div>
                    <div class="data-value">
                        <p id="3"><?php echo($input_ip); ?></p>
                    </div>
                </button>
                <button class="data-instance" onclick="copyToClipboard(4)">
                    <div class="data-instance-title">
                        <h1>Input Hex</h1>
                        <div class="data-instance-copy-img">
                            <img src="/img/icon/clipboard-copy.png">
                        </div>
                    </div>
                    <div class="data-value">
                        <p id="4"><?php echo($input_hex); ?></p>
                    </div>
                </button>
            </div>

            <div class="data-row">
                <button class="data-instance" onclick="copyToClipboard(5)">
                    <div class="data-instance-title">
                        <h1>CIDR</h1>
                        <div class="data-instance-copy-img">
                            <img src="/img/icon/clipboard-copy.png">
                        </div>
                    </div>
                    <div class="data-value">
                        <p id="5"><?php echo($CIDR); ?></p>
                    </div>
                </button>
                <button class="data-instance-cidr-long" onclick="copyToClipboard(6)">
                    <div class="data-instance-title">
                        <h1>CIDR Long Range</h1>
                        <div class="data-instance-copy-img">
                            <img src="/img/icon/clipboard-copy.png">
                        </div>
                    </div>
                    <div class="data-value">
                        <p id="6"><?php echo($CIDR_long_range); ?></p>
                    </div>
                </button>
                <button class="data-instance-cidr-long" onclick="copyToClipboard(7)">
                    <div class="data-instance-title">
                        <h1>CIDR IP Range</h1>
                        <div class="data-instance-copy-img">
                            <img src="/img/icon/clipboard-copy.png">
                        </div>
                    </div>
                    <div class="data-value">
                        <p id="7"><?php echo($CIDR_ip_range); ?></p>
                    </div>
                </button>
                <button class="data-instance-cidr-long" onclick="copyToClipboard(8)">
                    <div class="data-instance-title">
                        <h1>CIDR Hex Range</h1>
                        <div class="data-instance-copy-img">
                            <img src="/img/icon/clipboard-copy.png">
                        </div>
                    </div>
                    <div class="data-value">
                        <p id="8"><?php echo($CIDR_hex_range); ?></p>
                    </div>
                </button>
            </div>

            <div class="data-row">
                <button class="data-instance" onclick="copyToClipboard(9)">
                    <div class="data-instance-title">
                        <h1>IPs in Range</h1>
                        <div class="data-instance-copy-img">
                            <img src="/img/icon/clipboard-copy.png">
                        </div>
                    </div>
                    <div class="data-value">
                        <p id="9"><?php echo($ips_in_range); ?></p>
                    </div>
                </button>
                <button class="data-instance" onclick="copyToClipboard(10)">
                    <div class="data-instance-title">
                        <h1>Mask Bits</h1>
                        <div class="data-instance-copy-img">
                            <img src="/img/icon/clipboard-copy.png">
                        </div>
                    </div>
                    <div class="data-value">
                        <p id="10"><?php echo($mask_bits); ?></p>
                    </div>
                </button>
                <button class="data-instance" onclick="copyToClipboard(11)">
                    <div class="data-instance-title">
                        <h1>Subnet Mask</h1>
                        <div class="data-instance-copy-img">
                            <img src="/img/icon/clipboard-copy.png">
                        </div>
                    </div>
                    <div class="data-value">
                        <p id="11"><?php echo($subnet_mask); ?></p>
                    </div>
                </button>
                <button class="data-instance" onclick="copyToClipboard(12)">
                    <div class="data-instance-title">
                        <h1>Hex Subnet Mask</h1>
                        <div class="data-instance-copy-img">
                            <img src="/img/icon/clipboard-copy.png">
                        </div>
                    </div>
                    <div class="data-value">
                        <p id="12"><?php echo($hex_subnet_mask); ?></p>
                    </div>
                </button>
                <button class="data-instance" onclick="copyToClipboard(13)">
                    <div class="data-instance-title">
                        <h1>Wildcard</h1>
                        <div class="data-instance-copy-img">
                            <img src="/img/icon/clipboard-copy.png">
                        </div>
                    </div>
                    <div class="data-value">
                        <p id="13"><?php echo($wildcard); ?></p>
                    </div>
                </button>
            </div>

        </div>



    </body>
</html>