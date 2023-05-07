package gui;

import com.codename1.ui.Button;
import com.codename1.ui.Command;
import com.codename1.ui.Dialog;
import com.codename1.ui.Display;
import com.codename1.ui.Form;
import com.codename1.ui.Label;
import com.codename1.ui.List;
import com.codename1.ui.events.ActionEvent;
import com.codename1.ui.events.ActionListener;
import com.codename1.ui.layouts.BorderLayout;
import com.codename1.ui.layouts.BoxLayout;
import com.codename1.ui.plaf.UIManager;
import com.codename1.ui.util.Resources;
import entity.Consultation;
import com.mycompany.myapp.services.ServiceConsultation;

import java.util.ArrayList;



public class DisplayForm extends Form {
    private final Resources theme;
    private List consultationsList;

    public DisplayForm(Form previous) {
        super("Consultations", BoxLayout.y());
        theme = UIManager.initFirstTheme("/theme");

        consultationsList = new List();
        add(new Label("List of consultations:"));
        add(consultationsList);
        ArrayList<Consultation> consultations = new ServiceConsultation().affichageConsultation();
        for (Consultation consultation : consultations) {
            consultationsList.addItem(consultation.toString());
        }

        Button backButton = new Button("Back");
backButton.addActionListener(e -> previous.showBack());


 Button deleteButton = new Button("Delete");
      deleteButton.addActionListener(e -> {
int selectedIndex = consultationsList.getSelectedIndex();
if (selectedIndex >= 0) {
   // Get the selected consultation
   Consultation selectedConsultation = consultations.get(selectedIndex);
  // System.out.println(selectedIndex);
   // Delete the selected consultation from the server
   ServiceConsultation.getInstance().deleteConsultation(selectedConsultation.getId());
   
   
    Dialog.show("Succes", "The reservation was succesfully deleted", "OK", null);
    
    
     consultations.remove(selectedIndex);

        // Remove the selected consultation from the List's data model
consultationsList.getModel().removeItem(selectedIndex);


} else {
   Dialog.show("Error", "Please select a consultation to delete", "OK", null);
}
});

       add(deleteButton);
add(backButton);
    }
}

