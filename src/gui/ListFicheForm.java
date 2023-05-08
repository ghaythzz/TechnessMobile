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
import com.codename1.ui.Label;
import com.codename1.ui.events.ActionEvent;
import com.codename1.ui.events.ActionListener;
import com.codename1.ui.layouts.BoxLayout;
import com.codename1.ui.plaf.UIManager;
import com.mycomany.entities.Fiche;
import com.mycomany.entities.Ordonnance;
import com.mycompany.myapp.services.ServiceFiche;
import com.mycompany.myapp.services.ServiceOrdonnance;
import java.util.ArrayList;

/**
 *
 * @author asus
 */
public class ListFicheForm extends Form {
    /*public ListFicheForm(Form previous , int id){
        setTitle("Fiche");
        getToolbar().addMaterialCommandToLeftBar("", FontImage.MATERIAL_ARROW_BACK
                , e-> previous.showBack()); // Revenir vers l'interface précédente
        ServiceFiche es = new ServiceFiche();

        Fiche f = es.getAllFiche(id);
        System.out.println(f.getId());
           Container c3 = new Container(BoxLayout.y());
               
                 
                 SpanLabel cat1= new SpanLabel("Num de tel :" + f.getTel());
                 SpanLabel cat2= new SpanLabel("Genre:" + f.getGenre());
                 SpanLabel cat3= new SpanLabel("Etat Clinique :" + f.getEtatClinique());
                 SpanLabel cat4= new SpanLabel("Assurance :" + f.getTypeAssurance());
               
                     
                      
                     
                        c3.add(cat1);
                        c3.add(cat2);
                        c3.add(cat3);
                        c3.add(cat4);
                        Button Modifier =new Button("Modifier");
                        c3.add(Modifier);
                        Modifier.getAllStyles().setBgColor(0xF36B08);
            System.out.println(f.getId());
                        Modifier.addActionListener(e-> new ModifierFicheForm(this,f.getId(),f).show());
                        add(c3);
              
            
          getToolbar().addMaterialCommandToLeftBar("", FontImage.MATERIAL_ARROW_BACK
                , e-> previous.showBack()); // Revenir vers l'interface précédente
                
            }*/
    public ListFicheForm(Form previous, int id) {
        setTitle("Fiche");
        
        // Use the Native look and feel
        /*try {
            UIManager.getInstance().setLookAndFeel("com.codename1.ui.plaf.UIManager$NativeLookAndFeel");
        } catch (Exception e) {
            System.err.println("Error setting Native LAF: " + e.getMessage());
        }*/
        
        getToolbar().addMaterialCommandToLeftBar("", FontImage.MATERIAL_ARROW_BACK, e -> previous.showBack());
        
        ServiceFiche es = new ServiceFiche();
        Fiche f = es.getAllFiche(id);
        
        Container c3 = new Container(BoxLayout.y());
        c3.setScrollableY(true);
        c3.setScrollableX(false);
        c3.getStyle().setMarginTop(50);
        c3.getStyle().setMarginBottom(50);
        
        Label titleLabel = new Label("Détails de la fiche");
        titleLabel.setUIID("CenterTitle");
        c3.add(titleLabel);
        
        c3.add(createDetail("Numéro de téléphone", String.valueOf(f.getTel())));
        c3.add(createDetail("Genre", f.getGenre()));
        c3.add(createDetail("État clinique", f.getEtatClinique()));
        c3.add(createDetail("Assurance", f.getTypeAssurance()));
        
        Button modifierButton = new Button("Modifier");
        modifierButton.setUIID("ModifierButton");
        modifierButton.addActionListener(e -> new ModifierFicheForm(this, f.getId(), f).show());
        c3.add(modifierButton);
        
        add(c3);
        
        getToolbar().addMaterialCommandToLeftBar("", FontImage.MATERIAL_ARROW_BACK, e -> previous.showBack());
    }
    
    private Container createDetail(String label, String value) {
        Container detailContainer = new Container(BoxLayout.y());
        
        Label labelLabel = new Label(label);
        labelLabel.getStyle().setFgColor(0x9E9E9E);
        detailContainer.add(labelLabel);
        
        SpanLabel valueLabel = new SpanLabel(value);
        valueLabel.getStyle().setFgColor(0x212121);
        detailContainer.add(valueLabel);
        
        detailContainer.getStyle().setMarginTop(10);
        detailContainer.getStyle().setMarginBottom(10);
        
        return detailContainer;
    }
}