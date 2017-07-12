
import {POST_COMMENT, POST_REPLY, UPDATE_COMMENT, UPDATE_REPLY} from './constants';

const reducer = function(state, action) {
    let new_state = state;
    switch(action.type){

        case POST_COMMENT:
            new_state.comments = [action.payload, ...state.comments];
            return new_state;

        case POST_REPLY:
            new_state.comments.map((comment, index) => {
                if(comment.id == action.payload.comment_id){
                    comment.replies = [...comment.replies, action.payload];
                }
            });
            return new_state;

        case UPDATE_COMMENT:
            new_state.comments.map((comment, index) => {
                if(comment.id == action.payload.id){
                    comment.commentMessage = action.text;
                }
            });
            return new_state;

        case UPDATE_REPLY:
            new_state.comments.map((comment, index) => {
                if(action.payload.comment_id == comment.id){
                    comment.replies.map((reply, index) => {
                        if(action.payload.id == reply.id){
                            reply.replyMessage = action.payload.replyMessage;
                        }
                    });
                }
            });
            return new_state;

        default:
            return state;
    }
};

export default reducer;


