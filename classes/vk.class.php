<?php

class VK
{
    // Core client part
    public function method($method, $params) {
        $url = 'https://api.vk.com/method/' . $method . '?' . $this->paramsToString($params);
        $response = json_decode(file_get_contents($url), TRUE);
        
        return $response;
    }

    private function paramsToString($params) {
        $str = '';
        foreach($params as $key => $value) {
            $str .= $key . '=' . $value . '&';
        }

        return trim($str, '&');
    }

    // Additional functions
    public function getPostsComments($params) {
        $posts = $this->method('wall.get', $params);
        $result = [];
        foreach($posts['response']['items'] as $post) {
            $comments = $this->method('wall.getComments', [
                'owner_id' => $params['owner_id'],
                'post_id'  => $post['id'],
                'extended' => '1',
                'v'        => $params['v']
            ]);

            foreach($comments['response']['items'] as $comment) {

                if($comment['text']) {
                    $author = $this->method('users.get', [
                        'user_ids' => $comment['from_id']
                    ]);

                    array_push($result, [
                        'first_name' => $author['response'][0]['first_name'],
                        'last_name' => $author['response'][0]['last_name'],
                        'date' => date('Y-m-d H:i:s', $comment['date']),
                        'text' => $comment['text']
                    ]);
                }
            }
        }

        return $result;
    }
}
?>
