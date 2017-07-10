import React, {Component} from 'react';
import {bindActionCreators} from 'redux';
import {updateReply} from '../actions';
import {connect} from 'react-redux';

class CommentReply extends Component{

    constructor(props){
        super(props);

        this.state = {
            text: this.props.replyMessage,
            editing: false
        }
    }

    updateReply(event, text, url){
        event.preventDefault();

        $.ajax({
            data: {reply_content: text},
            url: url,
            type: 'POST',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            async: true,
            timeout: 30000,
            dataType: 'json'
        }).done((responsedata) => {
            this.props.updateReply(text, url, responsedata);
            this.props.app.setState(this.props.store);
            this.setState({editing: false});
        });
    }

    cancelUpdate(){
        this.setState({editing: false, text: this.props.replyMessage});
    }

    renderEditButton(){
        if(this.props.store.auth_guest == false){
            if(this.props.store.auth_user.id == this.props.user_id){
                return(
                    <span><button onClick={() => this.setState({editing: true})} style={{marginLeft: 30}} className="btn btn-default btn-circle">EDIT</button></span>
                );
            }
        }
    }

    render_edit(){
        return(
            <li>
                <div className="comment-avatar"><a href={this.props.profileURL}><img src={this.props.imageURL} alt=""/></a></div>
                <div className="comment-box">
                    <div className="comment-head">
                        <h6 className="comment-name"><a href={this.props.profileURL}>{this.props.username}</a></h6>
                        <span style={{marginTop: 7}}>posted {this.props.createdAt}</span>
                    </div>
                    <form onSubmit={(event) => this.updateReply(event, this.state.text, this.props.updateReplyURL)}>
                        <div id="reply-content" className="comment-content">
                            <textarea rows="4" onChange={(event) => this.setState({text: event.target.value})} className="form-control" value={this.state.text}/>
                        </div>
                        <span>
                            <button onClick={() => this.cancelUpdate()}
                                    style={{float: "right", marginBottom: 12, marginRight: 12}} value="CANCEL" type="submit" className="btn btn-danger btn-circle">CANCEL</button>
                            <input style={{float: "right", marginBottom: 12, marginRight: 12}} value="SAVE CHANGES" type="submit" className="btn btn-success btn-circle" />
                        </span>
                    </form>
                </div>
            </li>
        );
    }

    render_display(){
        return(
            <li>
                <div className="comment-avatar"><a href={this.props.profileURL}><img src={this.props.imageURL} alt=""/></a></div>
                <div className="comment-box">
                    <div className="comment-head">
                        <h6 className="comment-name"><a href={this.props.profileURL}>{this.props.username}</a></h6>
                        <span style={{marginTop: 7}}>posted {this.props.createdAt}</span>
                        {this.renderEditButton()}
                    </div>
                    <div id="reply-content" className="comment-content">
                        {this.props.replyMessage}
                    </div>
                </div>
            </li>
        );
    }

    render(){
        if(this.state.editing == false) {
            return this.render_display();
        } else {
            return this.render_edit();
        }
    }
}

function mapStateToProps(store){
    return {store: store}
}

function mapDispatchToProps(dispatch){
    return bindActionCreators({updateReply},dispatch);
}

export default connect(mapStateToProps, mapDispatchToProps)(CommentReply);

