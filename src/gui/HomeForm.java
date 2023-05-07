/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package gui;

import com.codename1.ui.Button;
import com.codename1.ui.Form;
import com.codename1.ui.Label;
import com.codename1.ui.layouts.BoxLayout;

/**
 *
 * @author bhk
 */
public class HomeForm extends Form{

    public HomeForm(Form previous) {
        
       setTitle("Home");
        setLayout(BoxLayout.y());
        
        add(new Label("Choose an option"));
        Button btnAddTask = new Button("Add Consultation");
        Button btnListTasks = new Button("Display Consultation");
        Button btnListReservations = new Button("Display Reservations");
        Button btnAddReservations = new Button("Book");
        btnListReservations.addActionListener(e-> new DisplayReservationForm(this).show());
         btnAddReservations.addActionListener(e-> new AddReservationForm(this).show());
        btnAddTask.addActionListener(e-> new AddForm(this).show());
        btnListTasks.addActionListener(e-> new DisplayForm(this).show());
        addAll(btnAddTask,btnListTasks,btnListReservations,btnAddReservations);    
        Button Back = new Button("Back to Profile");
        
       Back.addActionListener(e -> new ProfileForm().show());
        add(Back);
        
        
        
    }
    
    
}
