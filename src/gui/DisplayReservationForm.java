/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
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
import entity.Reservation;
import com.mycompany.myapp.services.ServiceReservation;

import java.util.ArrayList;

/**
 *
 * @author selmi
 */
public class DisplayReservationForm extends Form{
    private final Resources theme;
    private List reservationsList;

    public DisplayReservationForm(Form previous) {
        super("Reservations", BoxLayout.y());
        theme = UIManager.initFirstTheme("/theme");

        reservationsList = new List();
        add(new Label("List of reservations:"));
        add(reservationsList);
        ArrayList<Reservation> reservations = new ServiceReservation().affichageReservation();
        for (Reservation reservation : reservations) {
            reservationsList.addItem(reservation.toString());
        }

        Button backButton = new Button("Back");
backButton.addActionListener(e -> previous.showBack());

 Button deleteButton = new Button("Delete");
      deleteButton.addActionListener(e -> {
int selectedIndex = reservationsList.getSelectedIndex();
if (selectedIndex >= 0) {
   // Get the selected consultation
   Reservation selected = reservations.get(selectedIndex);
   
   // Delete the selected consultation from the server
  // System.out.println(selected.getId());
  ServiceReservation.getInstance().deleteReservation(selected.getId());
   
   
    Dialog.show("Succes", "The reservation was succesfully deleted", "OK", null);
    
    
     reservations.remove(selectedIndex);

        // Remove the selected consultation from the List's data model
reservationsList.getModel().removeItem(selectedIndex);


} else {
   Dialog.show("Error", "Please select a consultation to delete", "OK", null);
}
});
      
       add(deleteButton);
add(backButton);
    }
    
    
}
