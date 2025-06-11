import './style.scss';
import { registerBlockType } from '@wordpress/blocks';
import Edit from './edit';

registerBlockType('mon-theme-aca/featured-post', {
    edit: Edit,
});