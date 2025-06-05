/**
 * WordPress dependencies
 */
import { registerBlockType } from '@wordpress/blocks';

/**
 * Internal dependencies
 */
import Edit from './edit';
import './style.scss';
import './editor.scss';

/**
 * Register block
 */
registerBlockType('mon-theme-aca/newsletter', {
    edit: Edit,
});
