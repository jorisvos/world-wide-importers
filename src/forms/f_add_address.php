<?php
    try {
        require('inc/config.php');
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['inputName'], $_POST['inputAddress'],$_POST['inputAddress2'],$_POST['inputAddress3'],$_POST['inputZip'],$_POST['inputCity'],$_POST['inputState'], $_POST['inputPhone'])) {
                // If all fields are filled

                $city = "%".$_POST['inputCity']."%";
                $state = $_POST['inputState'];

                // Values for queries
                $cityName = $_POST['inputCity'];
                $stateID = $_POST['inputState'];
                $cityLocation = null;
                $cityPopulation = null;
                $currentUser = $_SESSION['PersonID'];
                $validFrom = "2013-01-01 00:00:00";
                $validUntil = "9999-12-31 23:59:59";
                
                // Call if city exists
                $stmt = $db->prepare("SELECT CityID, CityName FROM cities WHERE CityName LIKE ? AND StateProvinceID = $state ");
                $stmt->execute(array($city));
                $row = $stmt->fetch();
                $cityID = "";
                if (empty($row)) {
                    // If city is not there

                    // Getting first next CityID before assigning new one
                    $cityIdQuery = $db->prepare("SELECT max(CityID) as id FROM cities");
                    $cityIdQuery->execute();
                    $maxID = $cityIdQuery->fetch();
        
                    // Autoincrement ID
                    $aiID = $maxID['id'] + 1;

                    $insertCityQuery = "INSERT INTO cities (`CityID`, `CityName`, `StateProvinceID`, `LastEditedBy`, `ValidFrom`, `ValidTo`) VALUES (:id, :city_name, :state_id, :last_edit, :valid_from, :valid_until)";
                    //Prepares statement and bind parameters
                    $dbinsert = $db->prepare($insertCityQuery);

                    $dbinsert->bindParam(':id', $aiID, PDO::PARAM_STR);
                    $dbinsert->bindParam(':city_name', $cityName, PDO::PARAM_STR);
                    $dbinsert->bindParam(':state_id', $stateID, PDO::PARAM_STR);
                    // $dbinsert->bindParam(':city_location', $cityLocation, PDO::PARAM_STR);
                    // $dbinsert->bindParam(':last_population', $cityPopulation, PDO::PARAM_STR);
                    $dbinsert->bindParam(':last_edit', $currentUser, PDO::PARAM_STR);
                    $dbinsert->bindParam(':valid_from', $validFrom, PDO::PARAM_STR);
                    $dbinsert->bindParam(':valid_until', $validUntil, PDO::PARAM_STR);

                    $dbinsert-> execute();
                    $cityID = $aiID;
                // City has been added
                } else {
                    $cityID = $row['CityID'];
                }
                // The $cityID has been set propperly;
                // Getting first next CityID before assigning new one
                $customerIdQuery = $db->prepare("SELECT max(CustomerID) as id FROM customers");
                $customerIdQuery->execute();
                $maxID = $customerIdQuery->fetch();

                // Autoincrement ID
                $customerAIID = $maxID['id'] + 1;
                $customerName = $_POST['inputName'];
                $customerCategoryID = 9; // Customer group
                $DeliveryMethod = 2; // Courier
                $customerMadeDate = date("Y-m-d");
                $customerDiscount = 0;
                $customerStatementSend = 0;
                $customerCreditHold = 0;
                $customerPaymentDays = 7;
                $customerPhoneFax = $_POST['inputPhone'];
                $google = "google.com";
                $customerDeliveryAddressLine = $_POST['inputAddress']." ".$_POST['inputAddress2'].$_POST['inputAddress3'];
                $customerPostalCode = $_POST['inputZip'];

                try {
                    $insertCustomerQuery = "INSERT INTO customers (
                        `CustomerID`, 
                        `CustomerName`, 
                        `BillToCustomerID`,
                        `CustomerCategoryID`,
                        `PrimaryContactPersonID`,
                        `DeliveryMethodID`,
                        `DeliveryCityID`,
                        `PostalCityID`,
                        `AccountOpenedDate`,
                        `StandardDiscountPercentage`,
                        `IsStatementSent`,
                        `IsOnCreditHold`,
                        `PaymentDays`,
                        `PhoneNumber`,
                        `FaxNumber`,
                        `WebsiteURL`,
                        `DeliveryAddressLine1`,
                        `DeliveryPostalCode`,
                        `PostalAddressLine1`,
                        `PostalPostalCode`,
                        `LastEditedBy`,
                        `ValidFrom`,
                        `ValidTo`) VALUES (
                            :c_id, 
                            :c_name, 
                            :c_bill, 
                            :c_category, 
                            :c_current_user, 
                            :c_delivery,
                            :c_city,
                            :c_postalcode_city,
                            :c_date_made_customer,
                            :c_discount,
                            :c_statement,
                            :c_on_hold,
                            :c_payment_days,
                            :c_phone,
                            :c_fax,
                            :c_site,
                            :c_address,
                            :c_zipcode_address,
                            :c_invoice_address,
                            :c_zipcode_invoice_address,
                            :c_made_by,
                            :c_from,
                            :c_until
                            )";
                    //Prepares statement and bind parameters
                    $dbinsertCustomer = $db->prepare($insertCustomerQuery);

                    $dbinsertCustomer->bindParam(':c_id', $customerAIID, PDO::PARAM_INT);
                    $dbinsertCustomer->bindParam(':c_name', $customerName, PDO::PARAM_STR);
                    $dbinsertCustomer->bindParam(':c_bill', $customerAIID, PDO::PARAM_INT);
                    $dbinsertCustomer->bindParam(':c_category', $customerCategoryID, PDO::PARAM_INT);
                    $dbinsertCustomer->bindParam(':c_current_user', $currentUser, PDO::PARAM_INT);
                    $dbinsertCustomer->bindParam(':c_delivery', $DeliveryMethod, PDO::PARAM_INT);
                    $dbinsertCustomer->bindParam(':c_city', $cityID, PDO::PARAM_INT);
                    $dbinsertCustomer->bindParam(':c_postalcode_city', $cityID, PDO::PARAM_INT);
                    $dbinsertCustomer->bindParam(':c_date_made_customer', $customerMadeDate, PDO::PARAM_STR);
                    $dbinsertCustomer->bindParam(':c_discount', $customerDiscount, PDO::PARAM_STR);
                    $dbinsertCustomer->bindParam(':c_statement', $customerStatementSend, PDO::PARAM_INT);
                    $dbinsertCustomer->bindParam(':c_on_hold', $customerCreditHold, PDO::PARAM_INT);
                    $dbinsertCustomer->bindParam(':c_payment_days', $customerPaymentDays, PDO::PARAM_INT);
                    $dbinsertCustomer->bindParam(':c_phone', $customerPhoneFax, PDO::PARAM_INT);
                    $dbinsertCustomer->bindParam(':c_fax', $customerPhoneFax, PDO::PARAM_INT);
                    $dbinsertCustomer->bindParam(':c_site', $google, PDO::PARAM_STR);
                    $dbinsertCustomer->bindParam(':c_address', $customerDeliveryAddressLine, PDO::PARAM_STR);
                    $dbinsertCustomer->bindParam(':c_zipcode_address', $customerPostalCode, PDO::PARAM_STR);
                    $dbinsertCustomer->bindParam(':c_invoice_address', $customerDeliveryAddressLine, PDO::PARAM_STR);
                    $dbinsertCustomer->bindParam(':c_zipcode_invoice_address', $customerPostalCode, PDO::PARAM_STR);
                    $dbinsertCustomer->bindParam(':c_made_by', $currentUser, PDO::PARAM_INT);
                    $dbinsertCustomer->bindParam(':c_from', $validFrom, PDO::PARAM_STR);
                    $dbinsertCustomer->bindParam(':c_until', $validUntil, PDO::PARAM_STR);


                    $dbinsertCustomer-> execute();

                    setAlert("Adres is toegevoegd.", "success");
                    header('Location: address.php');
                } catch (Exception $e) {
                    setAlert("Customers error.", "danger", $e);
                    header('Location: address.php');
                }
            } else {
                setAlert("Een verplicht veld is niet ingevuld.", "warning");
                header('Location: address.php');
            }
        } else {
            setAlert("Er is geen formulier verstuurd.", "warning");
            header('Location: address.php');
        }
    } catch (Exception $e) {
        setAlert("Unkwown error.", "primary", $e);
        header('Location: address.php');
    }
