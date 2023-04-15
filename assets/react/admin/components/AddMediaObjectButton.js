import React from "react";
import { Link } from "react-router-dom";
import ImageIcon from "@mui/icons-material/ImageTwoTone";
import withStyles from '@mui/styles/withStyles';
import { Button } from "react-admin";

const styles = {
  button: {
    marginTop: "1em",
    marginBottom: "1em",
  },
};

const AddMediaObjectButton = ({ classes, record }) => {
console.log();
  return (
    <Button
      className={classes.button}
      variant="contained"
      component={Link}
      to={{
        pathname: "/media_objects/create",
        // Here we specify the initial record for the create view
        state: { record: record }
      }}
      label="Add a MediaObject"
      title="Add a MediaObject"
    >
      <ImageIcon />
    </Button>
  );
};

export default withStyles(styles)(AddMediaObjectButton);
