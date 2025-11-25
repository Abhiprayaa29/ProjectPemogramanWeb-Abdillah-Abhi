<?php
// WAJIB: Mulai sesi untuk baca data login user
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? $pageTitle : 'JogjaLensa'; ?></title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="icon" type="image/png" href="assets/favicon.png">
    
    <style>
        /* 1. SMOOTH SCROLLING */
        html {
            scroll-behavior: smooth;
        }

        /* 2. PAGE TRANSITION */
        body {
            opacity: 0; 
            transition: opacity 0.6s ease-out; 
        }
        
        body.loaded {
            opacity: 1; 
        }

        /* 3. HOVER EFFECTS */
        .card, .btn, .nav-link {
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        }

        .btn:active {
            transform: scale(0.95);
        }

        .hover-shadow:hover {
            transform: translateY(-5px);
            box-shadow: 0 1rem 3rem rgba(0,0,0,.175)!important;
        }

        /* 4. LOADING SPINNER */
        #page-loader {
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background: #ffffff;
            z-index: 9999;
            display: flex;
            justify-content: center;
            align-items: center;
            transition: opacity 0.5s ease;
            pointer-events: none; 
        }
        
        /* Tambahan: Style khusus tombol musik pulse */
        @keyframes pulse {
            0% { box-shadow: 0 0 0 0 rgba(220, 53, 69, 0.7); }
            70% { box-shadow: 0 0 0 15px rgba(220, 53, 69, 0); }
            100% { box-shadow: 0 0 0 0 rgba(220, 53, 69, 0); }
        }
        .pulse-animation {
            animation: pulse 2s infinite;
        }
        
        /* Tambahan: Text Shadow untuk tulisan di atas video */
        .text-shadow {
            text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
        }
    </style>
</head>
<body class="bg-light">
    <div id="page-loader">
        <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>