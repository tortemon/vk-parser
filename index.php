<?php
    require('classes/vk.class.php');
    require('classes/export.class.php');

    $config = json_decode(file_get_contents('config.json'), TRUE);

    $vk = new VK();
    $comments = $vk->getPostsComments([
        'owner_id' => $config['owner_id'],
        'count'    => $config['count']['posts'],
        'v'        => $config['version']
    ]);

    switch($config['export']) {
        case 'json':
            Export::toJSON($config['filename'], $comments);
        break;

        case 'csv':
            Export::toCSV($config['filename'], $comments);
        break;

        default:
            Export::toJSON($config['filename'], $comments);
        break;
    }

    echo 'Экспортировано ' . count($comments) . ' комментариев';
?>
