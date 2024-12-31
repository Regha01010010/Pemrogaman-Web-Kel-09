<?php
if (extension_loaded("sqlsrv.dll")) {
    echo "SQL Server driver is loaded successfully!";
} else {
    echo "Failed to load SQL Server driver.";
}
?>