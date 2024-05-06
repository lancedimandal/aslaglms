<?php

include "../admin/includes/header.php";



?>

<style>
    body {
        max-width: 150;
        margin: 0 auto;
    }

    h2 {
        color: #00224b;
        font-size: 28px;
        margin-bottom: 10px;
    }

    p {
        font-size: 16px;
        margin-bottom: 15px;
    }

    .project-info {
        background-color: #f2f2f2;

        border-radius: 8;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .programmers {
        font-weight: bold;
        margin-bottom: 5px;
    }

    .adviser {
        font-weight: bold;
        margin-bottom: 5px;
        color: #044490;
    }

    .coordinator {
        font-weight: bold;
        color: #044490;
    }
</style>

<div class="container-fluid px-4">
    <h1 class="mt-4">About</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Others</li>
        <li class="breadcrumb-item">About</li>
    </ol>

    <div class="project-info">
        <h2>Capstone Project</h2>
        <p>This project held paramount importance as a vital component of the Capstone 2 requirement within the esteemed
            Institute of Information Technology at the City College of San Fernando Pampanga. Its substantial
            contribution significantly advanced the pursuit of the Bachelor of Science degree in Information Technology.
        </p>

        <p class="programmers">Programmed by: Charvin Jay G. Caingles & Lance Christopher D. Dimandal</p>
        <p class="adviser">Thesis Adviser: Mr. Justine G. Francisco</p>
        <p class="coordinator">Capstone Coordinator: Mr. Jerome C. Baluyut, MSIT</p>
    </div>



    <?php
    include "../admin/includes/footer.php";
    include "../admin/includes/scripts.php";
    ?>