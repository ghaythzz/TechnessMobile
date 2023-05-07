/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package gui;

import com.codename1.ui.Button;
import com.codename1.ui.Display;
import com.codename1.ui.Form;
import com.codename1.ui.TextField;
import com.codename1.ui.events.ActionEvent;
import com.codename1.ui.events.ActionListener;
import com.codename1.ui.layouts.BoxLayout;
import com.codename1.ui.spinner.Picker;
import entity.Reservation;
import java.text.SimpleDateFormat;
import java.util.Date;
import com.mycompany.myapp.services.ServiceReservation;

/**
 *
 * @author selmi
 */
public class AddReservationForm extends Form{
    
    private TextField commentField;
    private Picker   startField;
    private Picker endField;
    private Button addButton;
    public AddReservationForm(Form previous) {
        
        super("Add Reservation", BoxLayout.y());

        commentField = new TextField("", "Comment", 20, TextField.ANY);
             startField = new Picker();
        startField.setType(Display.PICKER_TYPE_DATE_AND_TIME);  
          endField = new Picker();
        endField.setType(Display.PICKER_TYPE_DATE_AND_TIME);
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
Date start = startField.getDate();
Date end = endField.getDate();

        Reservation consultation = new Reservation(start, end, comment);
        ServiceReservation.getInstance().ajouterReservation(consultation);

        // show a success message
        // ...

        // navigate back to the previous form
        this.getComponentForm().showBack();
    }
    
    
}
