import { combineReducers } from 'redux';
import PageLoading from './PageLoading';
import FieldComponents from './FieldComponents';
import FormFieldEditor from './FormFieldEditor';
import Sidebar from './Sidebar';
import SidebarSettings from './SidebarSettings';
import Grid from './Grid';
import FieldComponentsHash from './FieldComponentsHash';
import FormInfo from './FormInfo';
import FormEmails from './FormEmails';
import TemplateSelecting from './TemplateSelecting';
import Errors from './Errors';
import PredefinedForms from './PredefinedForms';
import ConditionalLogic from './ConditionalLogic';
import Ui from './Ui';

const rootReducer = combineReducers({
	Ui,
	PageLoading,
	FieldComponents,
	FormFieldEditor,
	FieldComponentsHash,
	Sidebar,
	SidebarSettings,
	Grid,
	TemplateSelecting,
	FormInfo,
	FormEmails,
	PredefinedForms,
	ConditionalLogic,
	Errors
});

export default rootReducer;
