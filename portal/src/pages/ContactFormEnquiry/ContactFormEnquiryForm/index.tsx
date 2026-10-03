import { useContactFormEnquiryForm } from "./useContactFormEnquiryForm";
import { Spinner } from "@/components/ui/spinner";
import { Field, FieldGroup, FieldLabel } from "@/components/ui/field";
import { Input } from "@/components/ui/input";
import { Button } from "@/components/ui/button";
import {
  Drawer,
  DrawerClose,
  DrawerContent,
  DrawerFooter,
  DrawerHeader,
  DrawerTitle,
} from "@/components/ui/drawer";
import {
  InputGroup,
  InputGroupAddon,
  InputGroupText,
  InputGroupTextarea,
} from "@/components/ui/input-group";

/*
 * ContactFormEnquiry Form Drawer
 */
export default function ContactFormEnquiryForm() {
  const { modal, data, isLoading, handleClose } = useContactFormEnquiryForm();
  return (
    <Drawer
      open={modal.show}
      onOpenChange={(v) => {
        if (!v) {
          handleClose();
        }
      }}
      swipeDirection="right"
    >
      <DrawerContent>
        <DrawerHeader>
          <DrawerTitle>View Enquiry</DrawerTitle>
        </DrawerHeader>
        <div className="flex-1 p-4">
          {isLoading ? (
            <Spinner className="size-6 mx-auto" />
          ) : (
            <div className="space-y-5 h-full flex flex-col">
              <div className="flex-1 scroll-fade overflow-y-auto">
                <FieldGroup>
                  <Field>
                    <FieldLabel htmlFor="enquiry-form-name">Name</FieldLabel>
                    <Input
                      value={data?.name}
                      readOnly
                      placeholder="Enter name"
                      autoComplete="off"
                      id="enquiry-form-name"
                    />
                  </Field>
                  <Field>
                    <FieldLabel htmlFor="enquiry-form-email">Email</FieldLabel>
                    <Input
                      value={data?.email}
                      readOnly
                      placeholder="Enter email"
                      autoComplete="off"
                      id="enquiry-form-email"
                    />
                  </Field>
                  <Field>
                    <FieldLabel htmlFor="enquiry-form-phone">Phone</FieldLabel>
                    <Input
                      value={data?.phone}
                      readOnly
                      placeholder="Enter phone"
                      autoComplete="off"
                      id="enquiry-form-phone"
                    />
                  </Field>
                  <Field>
                    <FieldLabel htmlFor="enquiry-form-page-url">
                      Page URL
                    </FieldLabel>
                    <Input
                      value={data?.page_url}
                      readOnly
                      placeholder="Enter page url"
                      autoComplete="off"
                      id="enquiry-form-page-url"
                    />
                  </Field>
                  <Field>
                    <FieldLabel htmlFor="enquiry-form-subject">
                      Subject
                    </FieldLabel>
                    <Input
                      value={data?.subject}
                      readOnly
                      placeholder="Enter subject"
                      autoComplete="off"
                      id="enquiry-form-subject"
                    />
                  </Field>
                  <Field>
                    <FieldLabel htmlFor="enquiry-form-message">
                      Message
                    </FieldLabel>
                    <InputGroup>
                      <InputGroupTextarea
                        value={data?.message}
                        id="enquiry-form-message"
                        placeholder="Enter message"
                        rows={6}
                        className="min-h-24 resize-none"
                      />
                      <InputGroupAddon align="block-end">
                        <InputGroupText className="tabular-nums">
                          {data?.message?.length ?? 0}
                          /500 characters
                        </InputGroupText>
                      </InputGroupAddon>
                    </InputGroup>
                  </Field>
                </FieldGroup>
              </div>
              <DrawerFooter className="py-0">
                <DrawerClose
                  render={<Button variant="outline" type="button" />}
                >
                  Close
                </DrawerClose>
              </DrawerFooter>
            </div>
          )}
        </div>
      </DrawerContent>
    </Drawer>
  );
}
