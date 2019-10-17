import React, { useState, useEffect } from 'react';
import RichTextEditor from 'react-rte';
import Grid from '@material-ui/core/Grid'
import TextField from '@material-ui/core/TextField'

const AddableFormEmail = (props) => {
	const [fromName, setFromName] = useState(props.emailData.fromName);
	const [fromEmail, setFromEmail] = useState(props.emailData.fromEmail);
	const [toEmail, setToEmail] = useState(props.emailData.toEmail);
	const [replyTo, setReplyTo] = useState(props.emailData.replyTo);
	const [ccEmail, setCcEmail] = useState(props.emailData.ccEmail);
	const [bccEmail, setBccEmail] = useState(props.emailData.bccEmail);
	const [emailAttachment, setEmailAttachment] = useState(props.emailData.emailAttachment);
	const [emailSubject, setEmailSubject] = useState(props.emailData.emailSubject);
	const [emailBody, setEmailBody] = useState(RichTextEditor.createEmptyValue().setContentFromString(props.emailData.emailBody, 'html'));
	const [index, setIndex] = useState(props.index)

	const getCurrentState = () => {
		return {
			fromName,
			fromEmail,
			toEmail,
			replyTo,
			ccEmail,
			bccEmail,
			emailAttachment,
			emailSubject,
			emailBody: emailBody.toString('html'),
			index,
		}
	}

	/**
	* When input changes, we need to update state
	*
	* @param {*} e
	* @param {*} key
	* @memberof AddableFormEmail
	*/
	const onChange = (e, key) => {
		switch (key) {
			case 'fromName':
				setFromName(e.target.value)
				break;
			case 'fromEmail':
				setFromEmail(e.target.value)
				break;
			case 'toEmail':
				setToEmail(e.target.value)
				break;
			case 'replyTo':
				setReplyTo(e.target.value)
				break;
			case 'ccEmail':
				setCcEmail(e.target.value)
				break;
			case 'bccEmail':
				setBccEmail(e.target.value)
				break;
			case 'emailAttachment':
				setEmailAttachment(e.target.value)
				break;
			case 'emailSubject':
				setEmailSubject(e.target.value)
				break;
			case 'emailBody':
				setEmailBody(e)
				break;
			case 'index':
				setIndex(e.target.value)
				break;
			default:
				break;
		}
	}

	useEffect(() => {
		if (props.onChange) {
			props.onChange(getCurrentState())
		}
	}, [
			fromName,
			fromEmail,
			toEmail,
			replyTo,
			ccEmail,
			bccEmail,
			emailAttachment,
			emailSubject,
			emailBody,
		])

	return (
		<div>
			<Grid container direction="row" spacing={8}>
				<Grid item xs={6}>
					<TextField type="text"
						id="fromName"
						label={KaliFormsObject.translations.formEmails.fromName}
						value={fromName}
						placeholder="John Doe..."
						fullWidth={true}
						variant="filled"
						onChange={(e) => onChange(e, 'fromName')}
					/>
				</Grid>
				<Grid item xs={6}>
					<TextField type="text"
						label={KaliFormsObject.translations.formEmails.fromEmail}
						id="fromEmail"
						value={fromEmail}
						placeholder="johndoe@wordpress.site"
						fullWidth={true}
						variant="filled"
						onChange={(e) => onChange(e, 'fromEmail')}
					/>
				</Grid>
			</Grid>
			<Grid container direction="row" spacing={8}>
				<Grid item xs={6}>
					<TextField type="text"
						label={KaliFormsObject.translations.formEmails.toEmail}
						id="toEmail"
						value={toEmail}
						placeholder="janedoe@wordpress.site"
						fullWidth={true}
						variant="filled"
						onChange={(e) => onChange(e, 'toEmail')} />
				</Grid>
				<Grid item xs={6}>
					<TextField type="text"
						label={KaliFormsObject.translations.formEmails.replyTo}
						id="replyTo"
						value={replyTo}
						placeholder="johndoe@wordpress.site"
						fullWidth={true}
						variant="filled"
						onChange={(e) => onChange(e, 'replyTo')} />
				</Grid>
			</Grid>
			<Grid container direction="row" spacing={8}>
				<Grid item xs={6}>
					<TextField type="text"
						label={KaliFormsObject.translations.formEmails.ccEmail}
						id="ccEmail"
						value={ccEmail}
						placeholder="johndoe@wordpress.site"
						fullWidth={true}
						variant="filled"
						onChange={(e) => onChange(e, 'ccEmail')} />
				</Grid>
				<Grid item xs={6}>
					<TextField type="text"
						label={KaliFormsObject.translations.formEmails.bccEmail}
						id="bccEmail"
						value={bccEmail}
						placeholder="janedoe@wordpress.site"
						fullWidth={true}
						variant="filled"
						onChange={(e) => onChange(e, 'bccEmail')} />
				</Grid>
			</Grid>
			<Grid container direction="row" spacing={8}>
				<Grid item xs={12}>
					<TextField type="text"
						label={KaliFormsObject.translations.formEmails.subject}
						id="emailSubject"
						value={emailSubject}
						placeholder={KaliFormsObject.translations.formEmails.subjectPlaceholder}
						fullWidth={true}
						variant="filled"
						onChange={(e) => onChange(e, 'emailSubject')} />
				</Grid>
			</Grid>
			<Grid container direction="row" spacing={8}>
				<Grid item xs={12}>
					<RichTextEditor className="kaliforms-post-editor"
						value={emailBody}
						onChange={e => onChange(e, 'emailBody')} />
				</Grid>
			</Grid>
		</div>
	)
}

export default AddableFormEmail
