import React from 'react';
import ReactDOM from 'react-dom';
import App from './components/App.jsx';
import {createStore} from 'redux';
import {Provider} from 'react-redux'
import reducer from './reducer.js';

const url = document.getElementById('root').dataset.url;

jQuery.ajax({
    url: url,
    type: "GET",
    async: true,
    timeout: 30000,
    dataType: 'json'
}).done((json_data) => {

    // store initial state
    let profile_urls = json_data.profile_urls;
    let image_urls = json_data.image_urls;
    let created_ats = json_data.created_ats;
    let update_urls = json_data.update_urls;
    let initial_comments = [];

    json_data.comments.map(function(comment, index){

        // replies
        let replies = json_data.replies.filter(function(reply, index){
            return comment.id === reply.comment_id;
        });

        // comments
        initial_comments = [...initial_comments, {
            profileURL: profile_urls[index],
            user_id: comment.user.id,
            imageURL: image_urls[index],
            username: comment.user.name,
            createdAt: created_ats[index],
            commentMessage: comment.content,
            commentUpdateURL: update_urls[index],
            replies: replies,
            id: comment.id,
            comment_reply_link: json_data.comment_reply_link
        }];

    });

    const initial_state = {
                            comments: initial_comments,
                            auth_guest: json_data.auth_guest,
                            auth_user: json_data.auth_user,
                            is_locked: json_data.is_locked
                          };

    const store = createStore(reducer, initial_state);
    ReactDOM.render(<Provider store={store}><App data={json_data} /></Provider>, document.getElementById('root'));

});












