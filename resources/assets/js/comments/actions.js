
import {POST_COMMENT, POST_REPLY} from './constants';

export const postComment = (text, url, payload) => {
    return {
        type: POST_COMMENT,
        postCommentUrl: url,
        text: text,
        payload: payload
    };
};

export const postReply = (text, url, payload) => {
    return {
        type: POST_REPLY,
        postCommentUrl: url,
        text: text,
        payload: payload
    };
};




