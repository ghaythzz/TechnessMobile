package gui;

import com.codename1.ui.Button;
import com.codename1.ui.Form;
import com.codename1.ui.TextField;
import com.codename1.ui.events.ActionEvent;
import com.codename1.ui.events.ActionListener;
import com.codename1.ui.layouts.BoxLayout;
import entity.Consultation;
import com.mycompany.myapp.services.ServiceConsultation;

public class AddForm extends Form {

    private TextField commentField;
    private TextField startField;
    private TextField endField;
    private Button addButton;

    public AddForm(Form previous) {
        super("Add Consultation", BoxLayout.y());

        commentField = new TextField("Comment", "", 20, TextField.ANY);
        startField = new TextField("Start", "", 20, TextField.ANY);
        endField = new TextField("End", "", 20, TextField.ANY);
        addButton = new Button("Add");

        addButton.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent evt) {
                addConsultation();
            }
        });
 
        addAll(commentField, startField, endField, addButton);
        Button backButton = new Button("Back");
backButton.addActionListener(e -> previous.showBack());
add(backButton);
    }

    

    private void addConsultation() {
        String comment = commentField.getText();
        String start = startField.getText();
        String end = endField.getText();

        Consultation consultation = new Consultation(start, end, comment);
        ServiceConsultation.getInstance().ajouterConsultation(consultation);

        // show a success message
        // ...

        // navigate back to the previous form
        this.getComponentForm().showBack();
    }

}
