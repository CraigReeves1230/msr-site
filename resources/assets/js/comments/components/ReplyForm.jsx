import React, {Component} from 'react';
import {postReply} from '../actions';
import {bindActionCreators} from 'redux';
import {connect} from 'react-redux';

class ReplyForm extends Component {

    constructor(props){
        super(props);

        this.state = {
            text: '',
            visible: false
        }
    }

    postReply(event, text, url){
        event.preventDefault();

        // save info to server
        jQuery.ajax({
            url: url,
            type: "POST",
            data: {reply_content: text, comment_id: this.props.comment_id},
            async: true,
            timeout: 30000,
            dataType: 'json'
        }).done((replydata) => {
            this.props.postReply(text, url, replydata);
            this.props.app.setState(this.props.store);
            this.refs.textarea.value = '';
            this.refs.textarea.focus();
        });
    }

    toggleVisible(){
        if(this.state.visible == true){
            this.setState({visible: false});
        } else {
            this.setState({visible: true});
        }
    }

    render(){
        console.log('App prop from reply form: ', this.props.app);
        console.log('Post Reply URL: ', this.props.postReplyURL);
        return(
            <span>
                <button onClick={() => this.toggleVisible()} className="btn btn-default btn-circle text-uppercase">Toggle Reply</button>
                <div className={this.state.visible ? "" : "hidden"}>
                    <form onSubmit={(event) => this.postReply(event, this.state.text, this.props.postReplyURL)} className="reply-form">
                        <div className="form-group" style={{marginTop: 10}}>
                            <label><h4>Comment Reply</h4></label>
                            <textarea onChange={(event) => this.setState({text: event.target.value})} ref="textarea" id="reply-content" className="form-control" name="reply_content" rows="3"></textarea>
                            <input type="hidden" value="{{$comment->id}}" name="comment_id" />
                            <input type="submit" value="Submit Reply" style={{marginTop: 10}} className="btn btn-primary" name="submit_reply"/>
                        </div>
                    </form>
                </div>
            </span>
            );
    }
}

function mapStateToProps(state){
    return {
        store: state
    }
}

function mapDispatchToProps(dispatch){
    return bindActionCreators({postReply}, dispatch);
}

export default connect(mapStateToProps, mapDispatchToProps)(ReplyForm);