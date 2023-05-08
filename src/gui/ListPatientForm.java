/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package gui;

import com.codename1.components.SpanLabel;
import com.codename1.ui.Button;
import com.codename1.ui.Command;
import com.codename1.ui.Container;
import com.codename1.ui.Dialog;
import com.codename1.ui.FontImage;
import com.codename1.ui.Form;
import com.codename1.ui.events.ActionEvent;
import com.codename1.ui.events.ActionListener;
import com.codename1.ui.layouts.BoxLayout;
import com.mycomany.entities.Fiche;
import com.mycomany.entities.Ordonnance;
import com.mycomany.entities.Utilisateur;
import com.mycompany.myapp.services.ServiceFiche;
import com.mycompany.myapp.services.ServiceOrdonnance;
import com.mycompany.myapp.services.ServiceUtilisateur;
import java.util.ArrayList;

/**
 *
 * @author asus
 */
public class ListPatientForm extends Form {
    public ListPatientForm(Form previous){
        setTitle("Liste des Patients");
        getToolbar().addMaterialCommandToLeftBar("", FontImage.MATERIAL_ARROW_BACK
                , e-> previous.showBack()); // Revenir vers l'interface précédente
        ServiceOrdonnance es = new ServiceOrdonnance();
        ServiceFiche fi = new ServiceFiche();
        ArrayList<Utilisateur> list = es.getAllPatient();
         {
           
            for (Utilisateur u : list) {

          
 
                Container c3 = new Container(BoxLayout.y());
               
                 SpanLabel cat1= new SpanLabel("Nom de patient :" + u.getNom());
             
                        c3.add(cat1);
                        Button Fiche =new Button("Fiche");
                        c3.add(Fiche);
                        Fiche.getAllStyles().setBgColor(0xF36B08);
                        Fiche.addActionListener(e-> new ListFicheForm(this ,u.getId()).show());
                        add(c3);  
            }
         }
    }
}
