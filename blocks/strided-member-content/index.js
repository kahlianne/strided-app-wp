/**
 * Block dependencies
 */
import classnames from 'classnames';
import Inspector from './inspector';
import attributes from './attributes';
import './style.scss';

const { __ } = wp.i18n;
const { registerBlockType, RichText, InspectorControls } = wp.blocks;
const { Spinner } = wp.components;
const { withSelect } = wp.data;

/**
 * Register static block example block
 */
export default registerBlockType('strided-app/strided-member-content', {
  title: 'Strided Member Content',
  description: 'Add the display for horses, arenas, and runs.',
  category: 'widgets',
  icon: 'star-filled',
  keywords: ['horse horses', 'arena arenas', 'run runs'],
  attributes,
  getEditWrapperProps(attributes) {
    const { blockAlignment } = attributes;
    if (
      'left' === blockAlignment ||
      'right' === blockAlignment ||
      'full' === blockAlignment
    ) {
      return { 'data-align': blockAlignment };
    }
  },
  edit: withSelect((select, props) => {
    const { getEntityRecords } = select('core');
    const type = props.attributes.radioControl;
    const numItems = props.attributes.rangeControl;
    return {
      posts: getEntityRecords('postType', type, {
        per_page: numItems
      })
    };
  })(props => {
    if (!props.posts) {
      return (
        props.isSelected && <Inspector {...props} />,
        (
          <p>
            <Spinner />
            {'Loading Posts'}
          </p>
        )
      );
    }
    if (props.posts && props.posts.length === 0) {
      return [
        props.isSelected && <Inspector {...props} />,
        <p>{'No Posts'}</p>
      ];
    }
    return [
      props.isSelected && <Inspector {...props} />,
      <ul>
        {props.posts.map(post => {
          return (
            <li>
              <a className={props.className} href={post.link}>
                {post.title.rendered}
              </a>
            </li>
          );
        })}
      </ul>
    ];
  }), // end withAPIData // end edit
  save() {
    // Rendering in PHP
    return null;
  }
});
