import { Avatar, AvatarFallback, AvatarImage } from "@/components/ui/avatar";
import { Button } from "@/components/ui/button";
import {
  InputGroup,
  InputGroupAddon,
  InputGroupInput,
} from "@/components/ui/input-group";
import { getNameInitials } from "@/utils/helper";
import { Trash2 } from "lucide-react";
import { useCallback, useEffect, useRef, useState } from "react";

type Props = {
  image?: string;
  value?: File;
  onChange: (value: File | undefined) => void;
};

function SingleImageInput({ image, value, onChange }: Props) {
  const inputRef = useRef<HTMLInputElement>(null);
  const [preview, setPreview] = useState<string | undefined>(image);

  useEffect(() => {
    if (!value) {
      setPreview(image);
      return;
    }

    const objectUrl = URL.createObjectURL(value);
    setPreview(objectUrl);

    return () => {
      URL.revokeObjectURL(objectUrl);
    };
  }, [value, image]);

  const handleChange = useCallback(
    (event: React.ChangeEvent<HTMLInputElement>) => {
      const file = event.target.files?.[0];

      if (!file) {
        return;
      }

      onChange(file);
    },
    [onChange],
  );

  const handleRemove = useCallback(() => {
    onChange(undefined);

    // Clear the native input so the same file can be selected again.
    if (inputRef.current) {
      inputRef.current.value = "";
    }
  }, [onChange]);

  return (
    <InputGroup className="w-full min-w-0">
      <InputGroupAddon align="inline-start" className="shrink-0 p-0">
        <Avatar className="h-8 w-8 rounded-xl">
          <AvatarImage
            src={preview}
            alt="Course Thumbnail"
            onError={() => setPreview(undefined)}
          />

          <AvatarFallback>{getNameInitials("Choose File")}</AvatarFallback>
        </Avatar>
      </InputGroupAddon>

      <InputGroupInput
        ref={inputRef}
        id="profile-image"
        type="file"
        accept="image/png,image/jpeg,image/jpg"
        onChange={handleChange}
        className="min-w-0 flex-1"
      />

      {value && (
        <InputGroupAddon align="inline-end" className="shrink-0 p-0 mr-0!">
          <Button
            type="button"
            variant="destructive"
            size="icon"
            onClick={handleRemove}
            aria-label="Remove image"
          >
            <Trash2 className="h-4 w-4" />
          </Button>
        </InputGroupAddon>
      )}
    </InputGroup>
  );
}

export default SingleImageInput;
