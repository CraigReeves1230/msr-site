
import {POST_COMMENT, POST_REPLY, UPDATE_COMMENT, UPDATE_REPLY} from './constants';

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

export const updateComment = (text, url, payload) => {
    return {
        type: UPDATE_COMMENT,
        postCommentUrl: url,
        text: text,
        payload: payload
    };
};

export const updateReply = (text, url, payload) => {
    return {
        type: UPDATE_REPLY,
        postCommentUrl: url,
        text: text,
        payload: payload
    };
};






