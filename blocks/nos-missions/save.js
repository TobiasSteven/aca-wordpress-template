/**
 * WordPress dependencies
 */
import { useBlockProps } from '@wordpress/block-editor';

/**
 * Save component
 * 
 * Since we're using a PHP render template, this should return null
 * The PHP template handles the rendering on both frontend and editor
 */
export default function save() {
    return null;
}
