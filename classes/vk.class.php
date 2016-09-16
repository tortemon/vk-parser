<?php

$config = [
    'owner_id' => '-1', //owner_id=-1 соответствует сообществам, owner_id=1 соответствует пользователям
    'count'    => 5 //Количество постов под которыми собираются комментарии
];

$wallJSON = json_decode(file_get_contents('https://api.vk.com/method/wall.get?owner_id=' . $config['owner_id'] . '&count=' . $config['count']), TRUE);

$result = [];

foreach($wallJSON['response'] as $post) {

    $commentJSON = json_decode(
        file_get_contents('https://api.vk.com/method/wall.getComments?owner_id=' . $config['owner_id'] . '&post_id=' . $post['id'] . '&extended=1&v=5'),
        TRUE
    );

    foreach($commentJSON['response']['items'] as $comment) {
        if($comment['text']) {

            $userDataJSON = json_decode(
                file_get_contents('https://api.vk.com/method/users.get?user_ids=' . $comment['from_id']),
                TRUE
            );

            $resultStr = $userDataJSON['response'][0]['first_name'] . ';' . date('Y-m-d H:i:s', $comment['date']) . ';' . $comment['text'];
            array_push($result, $resultStr);
        }
    }
}

foreach($result as $comment) {
    file_put_contents('result.csv', $comment . "\r\n", FILE_APPEND | LOCK_EX);
}

echo count($result) . ' комментариев записано';

?>
