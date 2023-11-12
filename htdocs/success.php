<?php 
    if(isset($_SESSION['success'])) :
?>
        <style>
            .alert-warning {color: #1ba404;}
        </style>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong><i class="fa-solid fa-circle-check"></i> Thành công :</strong> <?= $_SESSION['success']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
<?php 
    unset($_SESSION['success']);
    endif;
?>