import React from "react";
import { Link } from "react-router-dom";
import ImageIcon from "@material-ui/icons/ImageTwoTone";
import { withStyles } from "@material-ui/core/styles";
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
        state: { record: { album_id: record['@id'] } },
      }}
      label="Add a MediaObject"
      title="Add a MediaObject"
    >
      <ImageIcon />
    </Button>
  );
};

export default withStyles(styles)(AddMediaObjectButton);
