<?php
// api.php
header('Content-Type: application/json');

// Include the configuration file
if (file_exists(dirname(__FILE__) . '/config.php')) {
    require_once dirname(__FILE__) . '/config.php';
}

$action = isset($_GET['action']) ? $_GET['action'] : (isset($_POST['action']) ? $_POST['action'] : 'list');

// Handle File Upload
if ($action === 'upload') {
    // 1. Password Check
    $providedPassword = isset($_POST['password']) ? $_POST['password'] : '';
    
    if (!defined('UPLOAD_PASSWORD') || $providedPassword !== UPLOAD_PASSWORD) {
        echo json_encode(array('success' => false, 'message' => 'Incorrect password.'));
        exit;
    }

    // 2. File Processing
    if (isset($_FILES['pack']) && $_FILES['pack']['error'] === UPLOAD_ERR_OK) {
        $filename = basename($_FILES['pack']['name']);
        
        if (preg_match('/^q.*\.txt$/i', $filename)) {
            $target = dirname(__FILE__) . '/' . $filename;
            if (move_uploaded_file($_FILES['pack']['tmp_name'], $target)) {
                echo json_encode(array('success' => true, 'message' => 'Upload successful.'));
                exit;
            }
        } else {
            echo json_encode(array('success' => false, 'message' => 'File name must start with "q" and end with ".txt".'));
            exit;
        }
    }
    echo json_encode(array('success' => false, 'message' => 'Upload failed.'));
    exit;
}

// Handle File Listing
if ($action === 'list') {
    $files = glob(dirname(__FILE__) . "/q*.txt");
    $packs = array();
    
    if ($files) {
        foreach ($files as $file) {
            $basename = basename($file);
            $handle = @fopen($file, "r");
            if ($handle) {
                $title = trim(fgets($handle));
                fclose($handle);
                
                if (empty($title) || strpos($title, 'Q:') === 0) {
                    $title = $basename; 
                }
                $packs[] = array('file' => $basename, 'title' => $title);
            }
        }
    }
    echo json_encode(array('success' => true, 'packs' => $packs));
    exit;
}
?>