import React, {Component} from 'react';
import {postComment} from '../actions';
import {bindActionCreators} from 'redux';
import {connect} from 'react-redux';

class CommentForm extends Component {
    constructor(props){
        super(props);

        this.state = {
            text: ''
        }
    }

    postComment(event, text, url){
        event.preventDefault();

        // save info to server
        jQuery.ajax({
            url: url,
            type: "POST",
            data: {message_content: text},
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            async: true,
            timeout: 30000,
            dataType: 'json'
        }).done((responsedata) => {
            this.props.postComment(text, url, responsedata);
            this.props.app.setState(this.props.store);
            this.refs.textarea.value = '';
            this.refs.textarea.focus();
        });
    }

    render(){
        return(
            <div>
                <form onSubmit={(event) => this.postComment(event, this.state.text, this.props.postCommentUrl)} className="comment-form" action={this.props.postCommentUrl} method="post">
                    <div className="form-group">
                        <label htmlFor="content">Leave Comment</label>
                        <textarea ref="textarea" onChange={(event) => this.setState({text: event.target.value})} className="form-control" name="message_content" id="commentsField" rows="5"/>
                        <input style={{marginTop: "8px"}} value="Submit" type="submit" className="btn btn-default" name="leave_comment" />
                    </div>
                </form>
            </div>
        );
    }

}

function mapDispatchToProps(dispatch){
    return bindActionCreators({postComment}, dispatch);
}

function mapStateToProps(state){
    return {
        store: state
    };
}

export default connect(mapStateToProps, mapDispatchToProps)(CommentForm);