
import {POST_COMMENT, POST_REPLY} from './constants';

const reducer = function(state, action) {
    let new_state = state;
    switch(action.type){
        case POST_COMMENT:
            new_state.comments = [action.payload, ...state.comments];
            return new_state;
        case POST_REPLY:
            console.log('action payload from reducer:', action.payload);
            new_state.comments.map((comment, index) => {
                if(comment.id == action.payload.comment_id){
                    comment.replies = [...comment.replies, action.payload]
                }
            });
            return new_state;
        default:
            return state;
    }
};

export default reducer;


