import React from 'react';
import { Link } from 'react-router-dom';
import ImageIcon from '@material-ui/icons/ImageTwoTone';
import { withStyles } from '@material-ui/core/styles';
import { Button } from 'react-admin';

const styles = {
    button: {
        marginTop: '1em',
        marginBotton: '1em'
    }
};

const AddMediaObjectButton = ({ classes, record }) => (
    <Button
        className={classes.button}
        variant="contained"
        component={Link}
        label="Add a MediaObject"
        title="Add a MediaObject"
    >
        <ImageIcon />
    </Button>
);

export default withStyles(styles)(AddMediaObjectButton);
